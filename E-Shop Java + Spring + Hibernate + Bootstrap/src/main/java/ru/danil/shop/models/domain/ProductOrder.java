package ru.danil.shop.models.domain;

import com.fasterxml.jackson.core.JsonProcessingException;
import com.fasterxml.jackson.databind.ObjectMapper;
import jakarta.persistence.*;
import org.hibernate.validator.constraints.Length;
import ru.danil.shop.models.service.ProductService;

import java.util.Date;
import java.util.Map;
import java.util.Set;
import java.util.TreeMap;
import java.util.stream.Collectors;

@Entity
public class ProductOrder {
    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Long id;
    @Length(max = 2048, message = "Максимальная длина сообщения 2048 символов")
    private String userComment;
    @ManyToOne(fetch = FetchType.EAGER)
    @JoinColumn
    private User user;
    private Date date;
    private String productInOrder;
    private String status;
    @Transient
    private Map<Product, Integer> products;

    public void createProducts(ProductService productService) throws JsonProcessingException {
        ObjectMapper mapper = new ObjectMapper();
        Map<String, Integer> productsMap = mapper.readValue(this.productInOrder, Map.class);
        Set<Long> idsProducts = productsMap.keySet().stream().map(el -> Long.parseLong(el)).collect(Collectors.toSet());
        Set<Product> productsInOrder = productService.getProductsByIds(idsProducts);
        this.products = new TreeMap<Product, Integer>((o1, o2) -> Long.compare(o1.getId(), o2.getId()));
        products.putAll(productsInOrder.stream().collect(Collectors.toMap(k -> k, v -> productsMap.get(v.getId().toString()))));
    }

    public long getTotalPrice(){
        return products.entrySet().stream().mapToInt(el -> el.getKey().getPrice()*el.getValue()).sum();
    }

    public Map<Product, Integer> getProducts() {
        return products;
    }

    public void setProducts(Map<Product, Integer> products) {
        this.products = products;
    }

    public Long getId() {
        return id;
    }

    public void setId(Long id) {
        this.id = id;
    }

    public String getUserComment() {
        return userComment;
    }

    public void setUserComment(String userComment) {
        this.userComment = userComment;
    }

    public User getUserId() {
        return user;
    }

    public void setUserId(User user) {
        this.user = user;
    }

    public Date getDate() {
        return date;
    }

    public void setDate(Date date) {
        this.date = date;
    }

    public User getUser() {
        return user;
    }

    public void setUser(User user) {
        this.user = user;
    }

    public String getProductInOrder() {
        return productInOrder;
    }

    public void setProductInOrder(String productInOrder) {
        this.productInOrder = productInOrder;
    }

    public String getStatus() {
        return status;
    }

    public void setStatus(String status) {
        this.status = status;
    }
}
