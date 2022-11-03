package ru.danil.shop.controllers;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.beans.factory.annotation.Value;
import org.springframework.security.access.prepost.PreAuthorize;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.*;
import org.springframework.web.multipart.MultipartFile;
import ru.danil.shop.models.domain.Category;
import ru.danil.shop.models.domain.Product;
import ru.danil.shop.models.service.CategoryService;
import ru.danil.shop.models.service.ProductService;

import java.io.File;
import java.io.IOException;
import java.util.ArrayList;
import java.util.Arrays;
import java.util.List;

@Controller
@PreAuthorize("hasAuthority('ADMIN')")
public class AdminProductController {
    @Autowired
    private ProductService productService;
    @Autowired
    private CategoryService categoryService;
    @Value("${upload.path}")
    private String uploadPath;

    @GetMapping("/admin/product/{product}/edit")
    public String adminProductEdit(
            @PathVariable Product product,
            Model model
    ){
        File[] files = new File(uploadPath + "/" + product.getId()).listFiles();
        List<String> fileNames = new ArrayList<>();
        if (files != null)
            fileNames = Arrays.stream(files).map(el->el.getName()).toList();
        model.addAttribute("categories", categoryService.getAll());
        model.addAttribute("object", product);
        model.addAttribute("pageType", "product");
        if (fileNames.size() > 0){
            model.addAttribute("files", fileNames.stream().filter(p -> !p.contains("main")).toList());
        }
        return "admin_item_edit";
    }

    @GetMapping("/admin/product/{product}/delete")
    public String adminProductDelete(
            @PathVariable Product product,
            Model model
    ){
        model.addAttribute("object", product);
        model.addAttribute("pageType", "product");
        return "admin_item_delete";
    }

    @GetMapping("/admin/product/new")
    public String adminProductAdd(Model model){
        List<Category> categories = categoryService.getAll();
        model.addAttribute("categories", categories);
        model.addAttribute("object", new Product());
        model.addAttribute("pageType", "product");
        return "admin_item_edit";
    }

    @DeleteMapping("/product/{product}")
    public String deleteProduct(
            @PathVariable("product") Product product
    ){
        productService.delete(product, uploadPath);
        return "redirect:/admin/product";
    }

    @PostMapping("/product/new")
    public String addProduct(
            @RequestParam("mainFile") MultipartFile mainFile,
            @RequestParam("files") MultipartFile[] files,
            @ModelAttribute("product") Product product
    ) throws IOException {
        productService.save(product);
        ControllerUtils.createFilesFromProduct(mainFile, files, uploadPath, product);
        productService.save(product);
        return "redirect:/admin/product";
    }

    @PatchMapping("/product/{id}")
    public String updateProduct(
            @RequestParam("mainFile") MultipartFile mainFile,
            @RequestParam("files") MultipartFile[] files,
            @ModelAttribute("product") Product product
    ) throws IOException {
        ControllerUtils.updateFilesFromProduct(mainFile, files, uploadPath, product);
        productService.update(product);
        return "redirect:/admin/product";
    }
}
