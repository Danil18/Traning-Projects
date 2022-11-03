package ru.danil.shop.models.repos;

import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;
import ru.danil.shop.models.domain.ProductOrder;
import ru.danil.shop.models.domain.User;

@Repository
public interface ProductOrderRepo extends JpaRepository<ProductOrder, Long> {

    Page<ProductOrder> findByUser(User user, Pageable pageable);
}
