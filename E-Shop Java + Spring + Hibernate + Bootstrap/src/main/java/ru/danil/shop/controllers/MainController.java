package ru.danil.shop.controllers;

import jakarta.servlet.http.HttpServletRequest;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.beans.factory.annotation.Value;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;
import org.springframework.data.domain.Sort;
import org.springframework.data.web.PageableDefault;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestParam;
import ru.danil.shop.models.domain.Category;
import ru.danil.shop.models.domain.Product;
import ru.danil.shop.models.service.CategoryService;
import ru.danil.shop.models.service.ProductService;

import java.io.File;
import java.util.Arrays;
import java.util.List;

@Controller
public class MainController {
    @Autowired
    private CategoryService categoryService;
    @Autowired
    private ProductService productService;

    @Value("${upload.path}")
    private String uploadPath;

    @GetMapping("/")
    public String main(
            Model model
    ) {
        List<Category> categories =  categoryService.getByStatus(true);
        for (int i = 0; i <categories.size(); i++){
            categories.get(i).setProductInCategory(productService.get3ProductByCategory(categories.get(i),true));
        }
        model.addAttribute("categories", categories);
        model.addAttribute("url", "");
        return "main";
    }

    @GetMapping("/feedback")
    public String feedback() {
        return "feedback";
    }

    @PostMapping("/feedback")
    public String feedbackSend(
            @RequestParam("email") String email,
            @RequestParam("feedback") String feedback,
            Model model
    ) {
        //Тут должна быть отправка почты с сообщением для админа, но почты админа нет
        model.addAttribute("messageType", "success");
        model.addAttribute("message", "Ваше сообщение успешно отправлено. Оно будет рассмотренно администратором в ближейшее время");
        return "message";
    }

    @GetMapping("/product/{product}")
    public String productView(
            @PathVariable Product product,
            HttpServletRequest request,
            Model model
    ) {
        File[] files = new File(uploadPath + "/" + product.getId()).listFiles();
        List<String> fileNames = files != null ? Arrays.stream(files).map(el->el.getName()).toList() : null;
        if (fileNames != null) {
            model.addAttribute("mainImg", product.getMainImg());
            if (fileNames.size() > 1) {
                model.addAttribute("files", fileNames.stream().filter(p -> !p.contains("main")).toList());
            }
        }
        model.addAttribute("product", product);
        return "product_view";
    }

    @GetMapping("/catalog")
    public String catalog(
            @PageableDefault(sort = {"id"}, direction = Sort.Direction.DESC) Pageable pageable,
            Model model
    ) {
        Page<Product> page = productService.getPage(true, pageable);
        model.addAttribute("categories", categoryService.getByStatus(true));
        model.addAttribute("page", page);
        model.addAttribute("url", "/catalog");
        model.addAttribute("pageBody", ControllerUtils.getNumbersForPageBar(page));
        return "catalog";
    }

    @GetMapping("/category/{category}")
    public String category(
            @PageableDefault(sort = {"id"}, direction = Sort.Direction.DESC) Pageable pageable,
            @PathVariable Category category,
            Model model
    ) {
        Page<Product> page = productService.getPageByCategory(category, true, pageable);
        model.addAttribute("categories", categoryService.getByStatus(true));
        model.addAttribute("page", page);
        model.addAttribute("categoryId", category.getId());
        model.addAttribute("url", "/category/" + category.getId());
        model.addAttribute("pageBody", ControllerUtils.getNumbersForPageBar(page));
        return "category";
    }

    @GetMapping("/about")
    public String about(Model model){
        model.addAttribute("url", "/about");
        return "about";
    }
}
