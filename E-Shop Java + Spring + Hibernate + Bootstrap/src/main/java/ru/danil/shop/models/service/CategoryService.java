package ru.danil.shop.models.service;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;
import org.springframework.stereotype.Service;
import ru.danil.shop.models.domain.Category;
import ru.danil.shop.models.repos.CategoryRepo;

import java.util.List;

@Service
public class CategoryService {

    @Autowired
    CategoryRepo categoryRepo;

    public List<Category> getAll() {
        return categoryRepo.findAll();
    }

    public Page<Category> getAll(Pageable pageable) {
        return categoryRepo.findAll(pageable);
    }
    public List<Category> getByStatus(boolean status) {
        return categoryRepo.findByStatusOrderBySortOrderAsc(status);
    }

    public void save(Category obj) {
        categoryRepo.save(obj);
    }

    public void delete(Category obj) {
        categoryRepo.delete(obj);
    }
}
