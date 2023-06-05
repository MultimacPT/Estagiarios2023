package com.example.natura;

import android.content.Context;
import android.content.SharedPreferences;

public class SessionManager {
    SharedPreferences sharedPreferences;
    SharedPreferences.Editor editor;

    public SessionManager(Context context) {
        sharedPreferences = context.getSharedPreferences("appkey", 0);
        editor = sharedPreferences.edit();
        editor.apply();
    }

    public void setLogin(boolean login) {
        editor.putBoolean("KEY_LOGIN", login);
        editor.commit();

    }


    public boolean getLogin() {
        return sharedPreferences.getBoolean("KEY_LOGIN", false);
    }

    public void setEncryptedLogin(String encryptedLogin) {
        editor.putString("KEY_ENCRYPTED_LOGIN", encryptedLogin);
        editor.commit();

    }


    public String getEncryptedLogin() {
        return sharedPreferences.getString("KEY_ENCRYPTED_LOGIN", "");
    }

    public void setUsername(String username) {
        editor.putString("KEY_USERNAME", username);
        editor.commit();
    }

    public String getUsername() {
        return sharedPreferences.getString("KEY_USERNAME", "");
    }

    public void setId(String id) {
        editor.putString("KEY_ID", id);
        editor.commit();
    }

    public String getId() {
        return sharedPreferences.getString("KEY_ID", "");
    }

    public void setEmail(String email) {
        editor.putString("KEY_EMAIL", email);
        editor.commit();
    }

    public String getEmail() {
        return sharedPreferences.getString("KEY_EMAIL", "");
    }

    public void setPhone(String phone) {
        editor.putString("KEY_PHONE", phone);
        editor.commit();
    }

    public String getPhone() {
        return sharedPreferences.getString("KEY_PHONE", "");
    }
}
