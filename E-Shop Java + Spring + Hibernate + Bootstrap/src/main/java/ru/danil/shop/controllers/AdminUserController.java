package ru.danil.shop.controllers;

import jakarta.validation.Valid;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.security.access.prepost.PreAuthorize;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.validation.BindingResult;
import org.springframework.web.bind.annotation.DeleteMapping;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PatchMapping;
import org.springframework.web.bind.annotation.PathVariable;
import ru.danil.shop.models.domain.Role;
import ru.danil.shop.models.domain.User;
import ru.danil.shop.models.service.UserService;

import java.util.Map;

@Controller
@PreAuthorize("hasAuthority('ADMIN')")
public class AdminUserController {
    @Autowired
    private UserService userService;

    @GetMapping("/admin/user/{user}/delete")
    public String adminUserDelete(
            @PathVariable User user,
            Model model
    ){
        model.addAttribute("object", user);
        model.addAttribute("pageType", "user");
        return "admin_item_delete";
    }

    @DeleteMapping("/user/{id}")
    public String deleteUser(
            @PathVariable("user") User user
    ){
        userService.delete(user);
        return "redirect:/admin/user";
    }

    @GetMapping("/admin/user/{user}/edit")
    public String adminUserEdit(
            @PathVariable User user,
            Model model
    ){
        model.addAttribute("object", user);
        model.addAttribute("roles", Role.values());
        model.addAttribute("pageType", "user");
        return "admin_item_edit";
    }

    @PatchMapping("/user/{userOld}")
    public String updateUser(
            @PathVariable User userOld,
            @Valid User userNew,
            BindingResult bindingResult,
            Model model
    ){
        boolean userError = false;
        if (!userNew.getUsername().equals(userOld.getUsername()) && userService.isExists(userNew)){
            model.addAttribute("usernameError", "Такой пользователь уже существует");
            userError = true;
        }
        if (bindingResult.hasErrors() || userError){
            Map<String, String> errors = ControllerUtils.getErrors(bindingResult);
            model.mergeAttributes(errors);
            model.addAttribute("object", userNew);
            model.addAttribute("roles", Role.values());
            model.addAttribute("pageType", "user");
            return "admin_item_edit";
        }
        userNew.setActive(true);
        userService.update(userOld, userNew);
        return "redirect:/admin/user";
    }
}
