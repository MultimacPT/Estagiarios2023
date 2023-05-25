package com.example.natura;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.AsyncTask;
import android.os.Bundle;
import android.util.Base64;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import java.io.IOException;
import java.net.HttpURLConnection;
import java.net.URL;
import java.security.KeyManagementException;
import java.security.NoSuchAlgorithmException;
import java.security.cert.X509Certificate;

import javax.net.ssl.HostnameVerifier;
import javax.net.ssl.HttpsURLConnection;
import javax.net.ssl.SSLContext;
import javax.net.ssl.TrustManager;
import javax.net.ssl.X509TrustManager;

public class Login extends AppCompatActivity {

    SessionManager sessionManager;
    EditText username;
    EditText password;
    Button loginButton;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);
        sessionManager = new SessionManager(getApplicationContext());


        username = findViewById(R.id.username);
        password =  findViewById(R.id.password);
        loginButton = findViewById(R.id.loginButtom);


        loginButton.setOnClickListener(it -> {
            String sUsername = username.getText().toString().trim();
            String sPassword = password.getText().toString().trim();

            if (sUsername.equals("")) {
                username.setError("Digite o Username");
            }
            if (sPassword.equals("")) {
                password.setError("Digite a Password");
            }

            authenticate(sUsername, sPassword);

        });

        if (sessionManager.getlogin()){
            startActivity(new Intent(getApplicationContext(),Dashboard.class));
            finish();
        }


    }

    private void authenticate(String username, String password) { //Authenticação via CRM

        SSLAccess();

        String authString = username + ":" + password;
        String encodedAuthString = Base64.encodeToString(authString.getBytes(), Base64.DEFAULT);

        String apiUrl = "https://mx.multimac.pt/mxv5/api/v1/App/user";

        new AuthenticationTask().execute(apiUrl, encodedAuthString);
    }

    private class AuthenticationTask extends AsyncTask<String, Void, Integer> {
        @Override
        protected Integer doInBackground(String... params) {
            String apiUrl = params[0];
            String authHeader = "Basic " + params[1];

            HttpURLConnection connection = null;

            try {
                URL url = new URL(apiUrl);
                connection = (HttpURLConnection) url.openConnection();
                connection.setRequestMethod("GET");
                connection.setRequestProperty("Authorization", authHeader);

                int responseCode = connection.getResponseCode();

                return responseCode;
            } catch (IOException e) {
                e.printStackTrace();
            } finally {
                if (connection != null) {
                    connection.disconnect();
                }
            }

            return null;
        }

        @Override
        protected void onPostExecute(Integer responseCode) {
            if (responseCode != null && responseCode == 200) {
                sessionManager.setlogin(true);
                sessionManager.setusername(username.getText().toString().trim());
                startActivity(new Intent( getApplicationContext(), Dashboard.class));
                finish();
            } else {
                Toast.makeText(getApplicationContext(), "ERRO! Credenciais inválidas.", Toast.LENGTH_SHORT).show();
            }
        }
    }

    private void SSLAccess(){ //Acesso a todos os SSL

        TrustManager[] trustAllCerts = new TrustManager[] { new X509TrustManager() {
            public X509Certificate[] getAcceptedIssuers() {
                return null;
            }
            public void checkClientTrusted(X509Certificate[] certs, String authType) {
            }
            public void checkServerTrusted(X509Certificate[] certs, String authType) {
            }
        } };
        SSLContext sc = null;
        try {
            sc = SSLContext.getInstance("SSL");
            sc.init(null, trustAllCerts, new java.security.SecureRandom());
        } catch (NoSuchAlgorithmException | KeyManagementException e) {
            e.printStackTrace();
        }
        HttpsURLConnection.setDefaultSSLSocketFactory(sc.getSocketFactory());

        // Create all-trusting host name verifier
        HostnameVerifier allHostsValid = (hostname, session) -> true;

        // Install the all-trusting host verifier
        HttpsURLConnection.setDefaultHostnameVerifier(allHostsValid);

    }

}

