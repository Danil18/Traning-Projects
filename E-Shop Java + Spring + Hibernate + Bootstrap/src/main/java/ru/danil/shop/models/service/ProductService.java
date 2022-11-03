package ru.danil.shop.models.service;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;
import org.springframework.stereotype.Service;
import ru.danil.shop.models.domain.Category;
import ru.danil.shop.models.domain.Product;
import ru.danil.shop.models.repos.ProductRepo;

import java.io.File;
import java.util.List;
import java.util.Set;

@Service
public class ProductService {
    @Autowired
    private ProductRepo productRepo;

    public Page<Product> getAll(Pageable pageable) {
        return productRepo.findAll(pageable);
    }

    public Page<Product> getPage(boolean status, Pageable pageable){
        return productRepo.findByStatus(status, pageable);
    }

    public Page<Product> getPageByCategory(Category category, boolean status, Pageable pageable){
        return productRepo.findByCategoryAndStatus(category, status, pageable);
    }

    public List<Product> get3ProductByCategory(Category category, boolean status){
        return productRepo.findFirst3ByCategoryAndStatusOrderByIdDesc(category, status);
    }

    public Set<Product> getProductsByIds(Set<Long> ids){
        return productRepo.findByIdIn(ids);
    }

    public void save(Product obj) {
        productRepo.save(obj);
    }

    public void delete(Product product, String uploadPath) {
        File dir = new File(uploadPath + "/" + product.getId());
        if (dir.exists())
            if (dir.listFiles().length > 0) {
                for (File file : dir.listFiles()) {
                    file.delete();
                }
                dir.delete();
            }
        productRepo.delete(product);
    }

    public void update(Product product) {
        Product productOld = productRepo.findById(product.getId()).get();
        if (product.getMainImg() == null && productOld.getMainImg() != null)
            product.setMainImg(productOld.getMainImg());
        productRepo.save(product);
    }
}
