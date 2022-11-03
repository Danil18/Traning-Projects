package ru.danil.shop.models.domain;

import jakarta.persistence.*;

import java.util.List;

@Entity
public class Category {
    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Long id;
    private String name;
    private Long sortOrder;
    private boolean status;
    @OneToMany(mappedBy = "category", fetch = FetchType.LAZY)
    private List<Product> productInCategory;

    public Long getId() {
        return id;
    }

    public void setId(Long id) {
        this.id = id;
    }

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    public Long getSortOrder() {
        return sortOrder;
    }

    public void setSortOrder(Long sortOrder) {
        this.sortOrder = sortOrder;
    }

    public boolean isStatus() {
        return status;
    }

    public void setStatus(boolean status) {
        this.status = status;
    }

    public List<Product> getProductInCategory() {
        return productInCategory;
    }

    public void setProductInCategory(List<Product> productInCategory) {
        this.productInCategory = productInCategory;
    }
}
