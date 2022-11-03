package ru.danil.shop.controllers;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;
import org.springframework.data.domain.Sort;
import org.springframework.data.web.PageableDefault;
import org.springframework.security.access.prepost.PreAuthorize;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.GetMapping;
import ru.danil.shop.models.domain.Category;
import ru.danil.shop.models.domain.Product;
import ru.danil.shop.models.domain.ProductOrder;
import ru.danil.shop.models.domain.User;
import ru.danil.shop.models.service.CategoryService;
import ru.danil.shop.models.service.ProductOrderService;
import ru.danil.shop.models.service.ProductService;
import ru.danil.shop.models.service.UserService;

@Controller
@PreAuthorize("hasAuthority('ADMIN')")
public class AdminController {
    @Autowired
    private ProductService productService;

    @Autowired
    private CategoryService categoryService;

    @Autowired
    private ProductOrderService orderService;

    @Autowired
    private UserService userService;

    @GetMapping("/admin")
    public String adminHome(Model model){
        model.addAttribute("url", "/admin");
        return "admin_main";
    }

    @GetMapping("/admin/product")
    public String adminProduct(
            @PageableDefault(sort = {"id"}, direction = Sort.Direction.DESC, size = 50) Pageable pageable,
            Model model
    ){
        Page<Product> page = productService.getAll(pageable);
        model.addAttribute("pageType", "product");
        model.addAttribute("page", page);
        model.addAttribute("pageBody", ControllerUtils.getNumbersForPageBar(page));
        return "admin_item";
    }

    @GetMapping("/admin/category")
    public String adminCategory(
            @PageableDefault(sort = {"id"}, direction = Sort.Direction.DESC, size = 50) Pageable pageable,
            Model model
    ){
        Page<Category> page = categoryService.getAll(pageable);
        model.addAttribute("pageType", "category");
        model.addAttribute("page", page);
        model.addAttribute("pageBody", ControllerUtils.getNumbersForPageBar(page));
        return "admin_item";
    }

    @GetMapping("/admin/order")
    public String adminOrder(
            @PageableDefault(sort = {"id"}, direction = Sort.Direction.DESC, size = 50) Pageable pageable,
            Model model
    ){
        Page<ProductOrder> page = orderService.getAll(pageable);
        model.addAttribute("pageType", "order");
        model.addAttribute("page", page);
        model.addAttribute("pageBody", ControllerUtils.getNumbersForPageBar(page));
        return "admin_item";
    }

    @GetMapping("/admin/user")
    public String adminUser(
            @PageableDefault(sort = {"id"}, direction = Sort.Direction.DESC, size = 50) Pageable pageable,
            Model model
    ){
        Page<User> page = userService.getAll(pageable);
        model.addAttribute("pageType", "user");
        model.addAttribute("page", page);
        model.addAttribute("pageBody", ControllerUtils.getNumbersForPageBar(page));
        return "admin_item";
    }
}
