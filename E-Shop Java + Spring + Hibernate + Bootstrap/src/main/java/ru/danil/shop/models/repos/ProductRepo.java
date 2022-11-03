package ru.danil.shop.models.repos;

import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Query;
import org.springframework.data.repository.query.Param;
import org.springframework.stereotype.Repository;
import ru.danil.shop.models.domain.Category;
import ru.danil.shop.models.domain.Product;

import java.util.List;
import java.util.Set;

@Repository
public interface ProductRepo extends JpaRepository<Product, Long> {

    @Query("select new ru.danil.shop.models.domain.Product" +
            "(p.id, p.name, p.code, p.price, p.quantity, p.brand, p.description, p.characteristics, p.mainImg) " +
            "from Product p where p.status = :status")
    Page<Product> findByStatus(@Param("status") boolean status, Pageable pageable);

    Page<Product> findByCategoryAndStatus(Category category, boolean status, Pageable pageable);
    List<Product> findFirst3ByCategoryAndStatusOrderByIdDesc(Category category, boolean status);
    Set<Product> findByIdIn(Set<Long> ids);
}
