package com.example.natura;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.AsyncTask;
import android.os.Bundle;
import android.util.Base64;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import org.json.JSONException;
import org.json.JSONObject;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
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
        password = findViewById(R.id.Edittextpass);
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

        if (sessionManager.getLogin()) {
            startActivity(new Intent(getApplicationContext(), Dashboard.class));
            finish();
        }


    }

    private void authenticate(String username, String password) { //Autenticação via CRM

        SSLAccess();

        String authString = username + ":" + password;
        String encodedAuthString = Base64.encodeToString(authString.getBytes(), Base64.DEFAULT);

        String apiUrl = "https://mx.multimac.pt/mxv5/api/v1/App/user";

        new AuthenticationTask().execute(apiUrl, encodedAuthString);
    }

    private class AuthenticationTask extends AsyncTask<String, Void, String> {

        private HttpURLConnection connection;

        @Override
        protected String doInBackground(String... params) {
            String apiUrl = params[0];
            String authHeader = "Basic " + params[1];

            connection = null;

            try {
                URL url = new URL(apiUrl);
                connection = (HttpURLConnection) url.openConnection();
                connection.setRequestMethod("GET");
                connection.setRequestProperty("Authorization", authHeader);

                int responseCode = connection.getResponseCode();

                if (responseCode == 200) {
                    InputStream inputStream = connection.getInputStream();
                    return convertStreamToString(inputStream);
                }
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
        protected void onPostExecute(String response) {
            if (response != null) {
                try {
                    JSONObject jsonObject = new JSONObject(response);
                    JSONObject userObject = jsonObject.getJSONObject("user");
                    String userId = userObject.getString("id");
                    String email = userObject.getString("emailAddress");
                    String phoneNumber = userObject.getString("phoneNumber");

                    // Imprimir os valores no console
                    System.out.println("ID do usuário: " + (userId.equals("null") ? "null" : userId));
                    System.out.println("Email: " + (email.equals("null") ? "null" : email));
                    System.out.println("Número de telefone: " + (phoneNumber.equals("null") ? "null" : phoneNumber));

                    sessionManager.setLogin(true);
                    sessionManager.setUsername(username.getText().toString().trim());
                    sessionManager.setId(userId);
                    sessionManager.setEmail(email);
                    sessionManager.setPhone(phoneNumber);
                    startActivity(new Intent(getApplicationContext(), Dashboard.class));
                    finish();
                } catch (JSONException e) {
                    e.printStackTrace();
                }
            } else {
                Toast.makeText(getApplicationContext(), "ERRO! Credenciais inválidas.", Toast.LENGTH_SHORT).show();
            }
        }


        private String convertStreamToString(InputStream inputStream) {
            BufferedReader reader = new BufferedReader(new InputStreamReader(inputStream));
            StringBuilder stringBuilder = new StringBuilder();
            String line;
            try {
                while ((line = reader.readLine()) != null) {
                    stringBuilder.append(line).append('\n');
                }
            } catch (IOException e) {
                e.printStackTrace();
            } finally {
                try {
                    inputStream.close();
                } catch (IOException e) {
                    e.printStackTrace();
                }
            }
            return stringBuilder.toString();
        }
    }

    private void SSLAccess() { //Acesso a todos os SSL

        TrustManager[] trustAllCerts = new TrustManager[]{new X509TrustManager() {
            public X509Certificate[] getAcceptedIssuers() {
                return null;
            }

            public void checkClientTrusted(X509Certificate[] certs, String authType) {
            }

            public void checkServerTrusted(X509Certificate[] certs, String authType) {
            }
        }};
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

