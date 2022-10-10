package com.example.sweater.models.util;

import com.example.sweater.models.User;

public abstract class MessageHelper {
    public static String getAuthorName(User author){
        return author != null ? author.getUsername() : "<none>";
    }
}
