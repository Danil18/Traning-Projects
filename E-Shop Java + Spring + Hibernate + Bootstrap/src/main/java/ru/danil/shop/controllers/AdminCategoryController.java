package ru.danil.shop.controllers;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.security.access.prepost.PreAuthorize;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.*;
import ru.danil.shop.models.domain.Category;
import ru.danil.shop.models.service.CategoryService;

@Controller
@PreAuthorize("hasAuthority('ADMIN')")
public class AdminCategoryController {
    @Autowired
    private CategoryService categoryService;

    @GetMapping("/admin/category/{category}/edit")
    public String adminCategoryEdit(
            @PathVariable Category category,
            Model model
    ){
        model.addAttribute("object", category);
        model.addAttribute("pageType", "category");
        return "admin_item_edit";
    }

    @GetMapping("/admin/category/{category}/delete")
    public String adminCategoryDelete(
            @PathVariable Category category,
            Model model
    ){
        model.addAttribute("object", category);
        model.addAttribute("pageType", "category");
        return "admin_item_delete";
    }

    @GetMapping("/admin/category/new")
    public String adminCategoryAdd(Model model){
        model.addAttribute("object", new Category());
        model.addAttribute("pageType", "category");
        return "admin_item_edit";
    }

    @PatchMapping("/category/{id}")
    public String updateCategory(
            @ModelAttribute("category") Category category
    ){
        categoryService.save(category);
        return "redirect:/admin/category";
    }

    @DeleteMapping("/category/{id}")
    public String deleteCategory(
            @PathVariable("category") Category category
    ){
        categoryService.delete(category);
        return "redirect:/admin/category";
    }

    @PostMapping("/category/new")
    public String addCategory(
            @ModelAttribute("category") Category category
    ){
        categoryService.save(category);
        return "redirect:/admin/category";
    }
}
