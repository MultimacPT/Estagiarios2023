package com.example.natura;
import android.content.Context;
import android.content.SharedPreferences;

public class SessionManager {
    SharedPreferences  sharedPreferences;
    SharedPreferences.Editor editor;

    public SessionManager(Context context) {
        sharedPreferences=context.getSharedPreferences("appkey", 0);
        editor = sharedPreferences.edit();
        editor.apply();
    }

    public void setlogin(boolean login){
        editor.putBoolean("KEY_LOGIN", login);
        editor.commit();

    }


    public  boolean getlogin(){
        return sharedPreferences.getBoolean("KEY_LOGIN", false);
    }

    public void setusername(String username){
        editor.putString("KEY_USERNAME", username);
        editor.commit();
    }

    public String getusername(){
        return  sharedPreferences.getString("KEY_USERNAME","");
    }
}
