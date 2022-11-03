package ru.danil.shop.models.service;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;
import org.springframework.security.core.userdetails.UserDetails;
import org.springframework.security.core.userdetails.UserDetailsService;
import org.springframework.security.core.userdetails.UsernameNotFoundException;
import org.springframework.security.crypto.password.PasswordEncoder;
import org.springframework.stereotype.Service;
import ru.danil.shop.models.domain.Role;
import ru.danil.shop.models.domain.User;
import ru.danil.shop.models.repos.UserRepo;

import java.util.Collections;
import java.util.UUID;

@Service
public class UserService implements UserDetailsService {
    @Autowired
    private UserRepo userRepo;
    @Autowired
    private MailSender mailSender;
    @Autowired
    private PasswordEncoder passwordEncoder;

    @Override
    public UserDetails loadUserByUsername(String username) throws UsernameNotFoundException {
        User user = userRepo.findByUsername(username);
        return user;
    }

    public boolean update(User userOld, User userNew) {
        if (!userNew.getUsername().equals(userOld.getUsername())){
            userOld.setUsername(userNew.getUsername());
        }
        boolean isEmailChanged = !userNew.getEmail().equals(userOld.getEmail());
        if (isEmailChanged){
            userOld.setEmail(userNew.getEmail());
            userOld.setActivationCode(UUID.randomUUID().toString());
        }
        if (!userNew.getPassword().isEmpty()){
            userOld.setPassword(passwordEncoder.encode(userNew.getPassword()));
        }
        if (!userNew.getPhone().equals(userOld.getPhone())){
            userOld.setPhone(userNew.getPhone());
        }
        if (userNew.isActive() != userOld.isActive()){
            userOld.setActive(userNew.isActive());
        }
        if (userNew.getRoles() != null){
            userOld.setRoles(userNew.getRoles());
        }
        userRepo.save(userOld);
        if (isEmailChanged){
            sendMessage(userOld);
        }
        return true;
    }

    public Page<User> getAll(Pageable pageable) {
        return userRepo.findAll(pageable);
    }

    public void delete(User user) {
        userRepo.delete(user);
    }

    public boolean isExists(User user){
        User userFromDb = userRepo.findByUsername(user.getUsername());
        if (userFromDb != null){
            return true;
        }
        return false;
    }

    public void addUser(User user){
        user.setActive(true);
        user.setRoles(Collections.singleton(Role.USER));
        user.setActivationCode(UUID.randomUUID().toString());
        user.setPassword(passwordEncoder.encode(user.getPassword()));
        userRepo.save(user);
        sendMessage(user);
    }

    private void sendMessage(User user) {
        if(!user.getEmail().isEmpty()){
            String message = String.format(
                    "Hello %s! \n" +
                            "Welcome to E-shop. Please, visit next link to confirm your email: http://localhost:8080/activate/%s",
                    user.getUsername(),
                    user.getActivationCode()
            );
            mailSender.send(user.getEmail(), "Activation code", message);
        }
    }

    public boolean activateUser(String code) {
        User user = userRepo.findByActivationCode(code);
        if (user == null)
            return false;

        user.setActivationCode(null);
        userRepo.save(user);
        return true;
    }
}
