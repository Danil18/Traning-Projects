package ru.danil.shop.controllers;

import org.springframework.data.domain.Page;
import org.springframework.validation.BindingResult;
import org.springframework.validation.FieldError;
import org.springframework.web.multipart.MultipartFile;
import ru.danil.shop.models.domain.Product;

import java.io.File;
import java.io.IOException;
import java.util.Map;
import java.util.stream.Collector;
import java.util.stream.Collectors;


public class ControllerUtils {
    static int[] getNumbersForPageBar(Page page){
        int totalPages = page.getTotalPages();
        if(totalPages > 7) {
            int pageNumber = page.getNumber() + 1;
            int[] head = pageNumber > 4 ? new int[] {1, -1} : new int[] {1, 2, 3};
            int[] tail = pageNumber < totalPages - 3 ? new int[] {-1, totalPages} : new int[] {totalPages - 2 , totalPages - 1, totalPages};
            int[] bodyBefore = pageNumber > 4 &&  pageNumber < totalPages - 1 ? new int[] {pageNumber - 2, pageNumber - 1} : new int[] {};
            int[] bodyAfter = pageNumber > 2 &&  pageNumber < totalPages - 3 ? new int[] {pageNumber + 1, pageNumber + 2} : new int[] {};
            int length = head.length + tail.length + bodyBefore.length + bodyAfter.length;
            int[] body = new int [length];
            int i;
            for (i = 0; i < head.length; i++)
                body[i] = head[i];
            for (int j = 0; j < bodyBefore.length; j++)
                body[++i] = bodyBefore[j];
            if (pageNumber > 3 &&  pageNumber < totalPages - 2)
                body[++i] = pageNumber;
            for (int j = 0; j < bodyAfter.length; j++)
                body[++i] = bodyAfter[j];
            for (int j = 0; j < tail.length; j++)
                body[++i] = tail[j];
            return body;
        } else {
            int[] body = new int[totalPages];
            for(int i = 1; i < totalPages + 1; i++)
                body[i-1] = i;
            return body;
        }
    }

    static void createFilesFromProduct(MultipartFile mainFile, MultipartFile[] files, String uploadPath, Product product) throws IOException {
        if (files[0].getOriginalFilename() != "" || mainFile.getOriginalFilename() != ""){
            Long id = product.getId();
            File uploadDir = new File(uploadPath + "/" + id);
            uploadDir.mkdir();
            int i = 0;
            if (mainFile.getOriginalFilename() == "") {
                mainFile = files[0];
                i++;
            }
            String filenameMain = "main" + mainFile.getOriginalFilename().substring(mainFile.getOriginalFilename().lastIndexOf("."));
            mainFile.transferTo(new File(uploadPath + "/" + id + "/" + filenameMain));
            product.setMainImg(filenameMain);
            if (files[0].getOriginalFilename() != "") {
                for (; i < files.length; i++) {
                    String filename = i + files[i].getOriginalFilename().substring(files[i].getOriginalFilename().lastIndexOf("."));
                    files[i].transferTo(new File(uploadPath + "/" + id + "/" + filename));
                }
            }
        }
    }

    static void updateFilesFromProduct(MultipartFile mainFile, MultipartFile[] files, String uploadPath, Product product) throws IOException {
        if (files[0].getOriginalFilename() != "" || mainFile.getOriginalFilename() != ""){
            Long id = product.getId();
            File uploadDir = new File(uploadPath + "/" + id);
            if (!uploadDir.exists()){
                uploadDir.mkdir();
            }
            File[] existsFiles = uploadDir.listFiles();
            if (mainFile.getOriginalFilename() != ""){
                if (existsFiles.length > 0)
                    existsFiles[existsFiles.length -1].delete();
                String filenameMain = "main" + mainFile.getOriginalFilename().substring(mainFile.getOriginalFilename().lastIndexOf("."));
                product.setMainImg(filenameMain);
                mainFile.transferTo(new File(uploadPath + "/" + id + "/"+ filenameMain));
            }
            if (files[0].getOriginalFilename() != ""){
                if (existsFiles.length > 1)
                    for (int i = 0; i < existsFiles.length - 1; i++){
                        existsFiles[i].delete();
                    }
                int i = 0;
                if (uploadDir.listFiles().length == 0){
                    String filename = "main" + files[0].getOriginalFilename().substring(files[0].getOriginalFilename().lastIndexOf("."));
                    files[0].transferTo(new File(uploadPath + "/" + id + "/" + filename));
                    product.setMainImg(filename);
                    i++;
                }
                for (; i < files.length; i++) {
                    String filename = i + files[i].getOriginalFilename().substring(files[i].getOriginalFilename().lastIndexOf("."));
                    files[i].transferTo(new File(uploadPath + "/" + id + "/" + filename));
                }
            }
        }
    }

    static Map<String, String> getErrors(BindingResult bindingResult) {
        Collector<FieldError, ?, Map<String, String>> collector = Collectors.toMap(
                fieldError -> fieldError.getField() + "Error",
                FieldError::getDefaultMessage
        );
        return bindingResult.getFieldErrors().stream().collect(collector);
    }

    static Map<Long, Integer> changeProductInCart(Long id, String action, Map<Long, Integer> productsInCart){
        switch (action){
            case "plus":
                if (productsInCart.get(id) != null)
                    productsInCart.put(id, productsInCart.get(id) + 1);
                break;
            case "minus":
                if (productsInCart.get(id) != null && productsInCart.get(id) > 1)
                    productsInCart.put(id, productsInCart.get(id) - 1);
                else
                    productsInCart.remove(id);
                break;
            case "del":
                if (productsInCart.get(id) != null)
                    productsInCart.remove(id);
                break;
        }
        return productsInCart;
    }
}
