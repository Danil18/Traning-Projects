package ru.danil.shop.controllers;

import com.fasterxml.jackson.core.JsonProcessingException;
import jakarta.servlet.http.HttpServletRequest;
import jakarta.servlet.http.HttpSession;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.security.core.annotation.AuthenticationPrincipal;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.*;
import ru.danil.shop.models.domain.Product;
import ru.danil.shop.models.domain.User;
import ru.danil.shop.models.service.ProductOrderService;
import ru.danil.shop.models.service.ProductService;

import java.util.HashMap;
import java.util.Map;
import java.util.Set;

@Controller
public class CartController {

    @Autowired
    private ProductService productService;
    @Autowired
    private ProductOrderService orderService;

    @GetMapping("/cart")
    public String cart (
            HttpSession session,
            Model model
    ){
        Map<Long, Integer> productsInCart = (Map<Long, Integer>) session.getAttribute("productsInCart");
        if (productsInCart != null && productsInCart.size() > 0){
            Set<Product> productList = productService.getProductsByIds(productsInCart.keySet());
            int totalPrice = productList.stream().mapToInt(el -> el.getPrice()*productsInCart.get(el.getId())).sum();
            model.addAttribute("productList", productList);
            model.addAttribute("totalPrice", totalPrice);
        }
        return "cart";
    }

    @GetMapping("/order/new")
    public String confirmationOrder (
            HttpSession session,
            Model model
    ){
        Map<Long, Integer> productsInCart = (Map<Long, Integer>) session.getAttribute("productsInCart");
        if (productsInCart != null && productsInCart.size() > 0){
            Set<Product> productList =  productService.getProductsByIds(productsInCart.keySet());
            int totalPrice = productList.stream().mapToInt(el -> el.getPrice()*productsInCart.get(el.getId())).sum();
            model.addAttribute("totalPrice", totalPrice);
        }
        return "order_new";
    }

    @PostMapping("/order")
    public String createOrder (
            @AuthenticationPrincipal User user,
            @RequestParam String userComment,
            HttpSession session
    ) throws JsonProcessingException {
        Map<Long, Integer> productsInCart = (Map<Long, Integer>) session.getAttribute("productsInCart");
        orderService.save(user, userComment, productsInCart);
        session.removeAttribute("productsInCart");
        return "redirect:/cart";
    }

    @GetMapping("/cart/{id}/{action}")
    public String changeCountProduct(
            @PathVariable Long id,
            @PathVariable String action,
            HttpSession session
    ){
        Map<Long, Integer> productsInCart = (Map<Long, Integer>) session.getAttribute("productsInCart");
        session.setAttribute("productsInCart", ControllerUtils.changeProductInCart(id, action, productsInCart));
        return "redirect:/cart";
    }

    @DeleteMapping("/cart")
    public String clearCart(HttpSession session){
        session.removeAttribute("productsInCart");
        return "redirect:/cart";
    }

    @PostMapping("/cart/add/{product}")
    public String addToCart (
            @PathVariable Product product,
            HttpSession session,
            HttpServletRequest request
    ){
        Map<Long, Integer> productsInCart = (Map<Long, Integer>) session.getAttribute("productsInCart");
        if (productsInCart == null){
            productsInCart = new HashMap<>();
        }
        if (productsInCart.containsKey(product.getId())){
            productsInCart.put(product.getId(), productsInCart.get(product.getId()) + 1);
        } else {
            productsInCart.put(product.getId(), 1);
        }
        session.setAttribute("productsInCart", productsInCart);
        return "redirect:" + request.getHeader("referer");
    }
}
