package ru.danil.shop.models.service;

import com.fasterxml.jackson.core.JsonProcessingException;
import com.fasterxml.jackson.databind.ObjectMapper;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;
import org.springframework.stereotype.Service;
import ru.danil.shop.models.domain.ProductOrder;
import ru.danil.shop.models.domain.User;
import ru.danil.shop.models.repos.ProductOrderRepo;

import java.util.Date;
import java.util.Map;

@Service
public class ProductOrderService {
    @Autowired
    ProductOrderRepo orderRepo;

    public Page<ProductOrder> getAll(Pageable pageable) {
        return orderRepo.findAll(pageable);
    }
    public Page<ProductOrder> getByUser(User user, Pageable pageable) {
        return orderRepo.findByUser(user, pageable);
    }

    public void update(ProductOrder oldOrder, ProductOrder newOrder) {
        oldOrder.setUserComment(newOrder.getUserComment());
        oldOrder.setStatus(newOrder.getStatus());
        orderRepo.save(oldOrder);
    }

    public void delete(ProductOrder obj) {
        orderRepo.delete(obj);
    }

    public void save(User user, String userComment, Map<Long, Integer> productsInCart) throws JsonProcessingException {
        ObjectMapper mapper = new ObjectMapper();
        String jsonProduct = mapper.writeValueAsString(productsInCart);
        ProductOrder order = new ProductOrder();
        order.setStatus("Новый заказ");
        order.setUserComment(userComment);
        order.setProductInOrder(jsonProduct);
        order.setUser(user);
        order.setDate(new Date());
        orderRepo.save(order);
    }
}
