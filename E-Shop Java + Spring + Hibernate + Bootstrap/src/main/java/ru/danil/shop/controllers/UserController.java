package ru.danil.shop.controllers;

import com.fasterxml.jackson.core.JsonProcessingException;
import jakarta.validation.Valid;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;
import org.springframework.data.domain.Sort;
import org.springframework.data.web.PageableDefault;
import org.springframework.security.core.annotation.AuthenticationPrincipal;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.validation.BindingResult;
import org.springframework.web.bind.annotation.*;
import ru.danil.shop.models.domain.ProductOrder;
import ru.danil.shop.models.domain.User;
import ru.danil.shop.models.service.ProductOrderService;
import ru.danil.shop.models.service.ProductService;
import ru.danil.shop.models.service.UserService;

import java.util.Map;

@Controller
public class UserController {
    @Autowired
    private UserService userService;
    @Autowired
    private ProductOrderService orderService;
    @Autowired
    private ProductService productService;

    @GetMapping("/registration")
    public String registration(Model model){
        model.addAttribute("user", new User());
        return "registration";
    }

    @PostMapping("/registration")
    public String addUser(
            @RequestParam("password2") String passwordConfirmation,
            @Valid User user,
            BindingResult bindingResult,
            Model model
    ){
        boolean isPasswordError = false;
        boolean isUserError = false;
        if (userService.isExists(user)) {
            model.addAttribute("usernameError", "Такой пользователь уже существует");
            isUserError = true;
        }
        if (passwordConfirmation.isEmpty()){
            model.addAttribute("password2Error", "Подтверждение пароля не может быть пустым");
            isPasswordError = true;
        }
        if (user.getPassword().isEmpty()){
            model.addAttribute("passwordError", "Пароль не может быть пустым");
            isPasswordError = true;
        } else if (!user.getPassword().isEmpty() && !user.getPassword().equals(passwordConfirmation)){
            model.addAttribute("passwordError", "Пароли не равны");
            isPasswordError = true;
        }
        if (isPasswordError || bindingResult.hasErrors() || isUserError){
            Map<String, String> errors = ControllerUtils.getErrors(bindingResult);
            model.mergeAttributes(errors);
            return "registration";
        }
        userService.addUser(user);
        return "redirect:/login";
    }

    @GetMapping("/activate/{code}")
    public String activate(
            Model model,
            @PathVariable String code
    ){
        boolean isActivated = userService.activateUser(code);
        if (isActivated){
            model.addAttribute("messageType", "success");
            model.addAttribute("message", "User successfully activated");
        } else {
            model.addAttribute("messageType", "danger");
            model.addAttribute("message", "Activation code is not found");
        }
        return "message";
    }

    @GetMapping("/user/edit")
    public String userEdit(
            @AuthenticationPrincipal User user,
            Model model
    ){
        model.addAttribute("user", user);
        return "user_edit";
    }

    @PatchMapping("/user/edit")
    public String updateUser(
            @RequestParam("password2") String passwordConfirmation,
            @AuthenticationPrincipal User userOld,
            @Valid User userNew,
            BindingResult bindingResult,
            Model model
    ){
        boolean isPasswordError = false;
        if (!userNew.getPassword().isEmpty())
            if (!userNew.getPassword().equals(passwordConfirmation)){
                model.addAttribute("passwordError", "Пароли не равны");
                isPasswordError = true;
            }
        boolean userError = false;
        if (!userNew.getUsername().equals(userOld.getUsername()) && userService.isExists(userNew)) {
                model.addAttribute("usernameError", "Такой пользователь уже существует");
                userError = true;
        }
        if (isPasswordError || bindingResult.hasErrors() || userError){
            Map<String, String> errors = ControllerUtils.getErrors(bindingResult);
            model.mergeAttributes(errors);
            return "user_edit";
        }
        userNew.setActive(true);
        userService.update(userOld, userNew);
        return "redirect:/cabinet";
    }

    @GetMapping("/cabinet")
    public String cabinet(
            @AuthenticationPrincipal User user,
            @PageableDefault(sort = {"id"}, direction = Sort.Direction.DESC, size = 10) Pageable pageable,
            Model model
    ) throws JsonProcessingException {
        Page<ProductOrder> orders = orderService.getByUser(user, pageable);
        if (orders.getTotalPages() > 0){
            for (ProductOrder order: orders.getContent())
                order.createProducts(productService);
            model.addAttribute("page", orders);
            model.addAttribute("url", "/cabinet");
            model.addAttribute("pageBody", ControllerUtils.getNumbersForPageBar(orders));
        } else {
            model.addAttribute("message", "У вас нет заказов");
        }
        return "cabinet";
    }
}
