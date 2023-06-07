package com.example.natura;

import android.os.AsyncTask;
import android.os.Bundle;
import android.util.Log;
import android.widget.TextView;

import androidx.appcompat.app.AppCompatActivity;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.URL;
import java.security.KeyManagementException;
import java.security.NoSuchAlgorithmException;
import java.security.cert.X509Certificate;
import java.util.Base64;

import javax.net.ssl.HostnameVerifier;
import javax.net.ssl.HttpsURLConnection;
import javax.net.ssl.SSLContext;
import javax.net.ssl.TrustManager;
import javax.net.ssl.X509TrustManager;

public class scan extends AppCompatActivity {

    private static final String API_URL = "https://mx.multimac.pt/mxv5/api/v1/Consumiveisvsmodelo?select=productId%2CproductName%2Cmodelo%2Cdescription%2CcreatedById%2CcreatedByName%2CcreatedAt%2CmodifiedById%2CmodifiedByName%2CmodifiedAt%2Cname&maxSize=25&offset=0&orderBy=createdAt&order=desc";
    private static final String TAG = scan.class.getSimpleName();

    SessionManager sessionManager;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_scan);

        sessionManager = new SessionManager(getApplicationContext());

        // Faz a autenticação
        new AuthenticateAsyncTask().execute();
    }

    private class AuthenticateAsyncTask extends AsyncTask<Void, Void, Boolean> {

        @Override
        protected Boolean doInBackground(Void... voids) {
            SSLAccess();
            HttpURLConnection connection = null;

            try {
                // Cria a conexão com a API
                URL url = new URL(API_URL);
                connection = (HttpURLConnection) url.openConnection();
                connection.setRequestMethod("GET");

                // Define o header de autenticação
                // LOOK HERE
                String encodedCredentials = "Basic YWZpZ3VlaXJlZG86R1cyMmJVMmd1SA==";
                connection.setRequestProperty("Authorization", encodedCredentials);

                // Faz a requisição e verifica a resposta
                int responseCode = connection.getResponseCode();
                return responseCode == HttpURLConnection.HTTP_OK;
            } catch (IOException e) {
                Log.e(TAG, "Error authenticating", e);
            } finally {
                if (connection != null) {
                    connection.disconnect();
                }
            }

            return false;
        }

        @Override
        protected void onPostExecute(Boolean isAuthenticated) {
            if (isAuthenticated) {
                Log.d(TAG, "Authentication successful");
            } else {
                Log.d(TAG, "Authentication failed");
            }
        }
    }

    public void SSLAccess() { //Acesso a todos os SSL

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

