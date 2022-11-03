package ru.danil.shop.controllers;

import com.fasterxml.jackson.core.JsonProcessingException;
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
import ru.danil.shop.models.domain.Product;
import ru.danil.shop.models.domain.ProductOrder;
import ru.danil.shop.models.service.ProductOrderService;
import ru.danil.shop.models.service.ProductService;

import java.util.Map;

@Controller
@PreAuthorize("hasAuthority('ADMIN')")
public class AdminOrderController {
    @Autowired
    private ProductOrderService orderService;
    @Autowired
    private ProductService productService;

    @GetMapping("/admin/order/{order}/edit")
    public String adminOrderEdit(
            @PathVariable ProductOrder order,
            Model model
    ){
        model.addAttribute("object", order);
        model.addAttribute("pageType", "order");
        return "admin_item_edit";
    }


    @GetMapping("/admin/order/{order}/delete")
    public String adminOrderDelete(
            @PathVariable ProductOrder order,
            Model model
    ){
        model.addAttribute("object", order);
        model.addAttribute("pageType", "order");
        return "admin_item_delete";
    }

    @PatchMapping("/order/{oldOrder}")
    public String updateOrder(
            @PathVariable ProductOrder oldOrder,
            @Valid ProductOrder newOrder,
            BindingResult bindingResult,
            Model model
    ){
        if (bindingResult.hasErrors()){
            Map<String, String> errors = ControllerUtils.getErrors(bindingResult);
            model.mergeAttributes(errors);
            model.addAttribute("object", newOrder);
            model.addAttribute("pageType", "order");
            return "admin_item_edit";
        }
        orderService.update(oldOrder, newOrder);
        return "redirect:/admin/order";
    }


    @DeleteMapping("/order/{order}")
    public String deleteOrder(
            @PathVariable("order") ProductOrder order
    ){
        orderService.delete(order);
        return "redirect:/admin/order";
    }

    @GetMapping("/admin/order/{order}")
    public String adminOrderView(
            @PathVariable ProductOrder order,
            Model model
    ) throws JsonProcessingException {
        order.createProducts(productService);
        model.addAttribute("order", order);
        return "order_view";
    }
}
