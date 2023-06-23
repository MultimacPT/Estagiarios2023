package com.example.natura;

import android.content.Intent;
import android.os.AsyncTask;
import android.os.Bundle;
import android.util.Log;
import android.view.KeyEvent;
import android.view.View;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

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

import javax.net.ssl.HostnameVerifier;
import javax.net.ssl.HttpsURLConnection;
import javax.net.ssl.SSLContext;
import javax.net.ssl.TrustManager;
import javax.net.ssl.X509TrustManager;

public class ScanActivity extends AppCompatActivity {

    private static final String API_URL = "https://mx.multimac.pt/mxv5/api/v1/Consumiveisvsmodelo?select=productId%2CproductName%2Cmodelo%2Cdescription%2CcreatedById%2CcreatedByName%2CcreatedAt%2CmodifiedById%2CmodifiedByName%2CmodifiedAt%2Cname&maxSize=25&offset=0&orderBy=createdAt&order=desc";
    private static final String TAG = ScanActivity.class.getSimpleName();

    public static String KEY_ENCRYPTED_LOGIN = "";

    private String responseJson;

    SessionManager sessionManager;

    private boolean isAuthenticated = false; // Authentication control

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_scan);

        sessionManager = new SessionManager(getApplicationContext());

        KEY_ENCRYPTED_LOGIN = sessionManager.getEncryptedLogin();


        TextView tBack = findViewById(R.id.tvBack);
        tBack.setEnabled(true);
        tBack.setOnClickListener(new View.OnClickListener() { //Back to NavigationActivity
            @Override
            public void onClick(View v) {
                Intent intent = new Intent(ScanActivity.this, NavigationActivity.class);
                startActivity(intent);
                finish();
            }
        });

        TextView tClean = findViewById(R.id.tvClean);
        tClean.setEnabled(true);
        tClean.setOnClickListener(new View.OnClickListener() { //Clean all fields
            @Override
            public void onClick(View v) {
                TextView tvID = findViewById(R.id.tvProductId);
                tvID.setEnabled(false);
                tvID.setText("");

                TextView tvName = findViewById(R.id.tvProductName);
                tvName.setEnabled(false);
                tvName.setText("");

                TextView tvDesc = findViewById(R.id.tvProductDescription);
                tvDesc.setEnabled(false);
                tvDesc.setText("");

                TextView tvModel = findViewById(R.id.tvProductModel);
                tvModel.setEnabled(false);
                tvModel.setText("");
            }
        });

        new AuthenticateAsyncTask().execute();
    }

    @Override
    public boolean dispatchKeyEvent(KeyEvent event) {
        int keyCode = event.getKeyCode();

        TextView tBack = findViewById(R.id.tvBack);
        tBack.setEnabled(false);
        TextView tClean = findViewById(R.id.tvClean);
        tClean.setEnabled(false);

        EditText input = findViewById(R.id.etInput);
        TextView tvId = findViewById(R.id.tvProductId);
        tvId.setEnabled(false);

        if (event.getAction() == KeyEvent.ACTION_DOWN && keyCode == KeyEvent.KEYCODE_ENTER) {
            // Get edittext's value
            String text = input.getText().toString();

            // set id's text
            tvId.setText(text);

            // clean edittext's text
            input.setText("");

            // Verify if user isn't authenticated
            if (!isAuthenticated) {
                new AuthenticateAsyncTask().execute();
                return true; // return to process
            }

            // verify input text, compare with webapi's ids
            verifyText(text);

            return true;
        }

        tBack.setEnabled(true);
        tClean.setEnabled(true);

        return super.dispatchKeyEvent(event);
    }

    private void verifyText(String text) {

        if (text.isEmpty()) {
            //if text is empty, come back to process, without compare with webapi
            return;
        }

        try {
            // JSON's parse returned by webapi
            JSONObject jsonObject = new JSONObject(responseJson);
            JSONArray list = jsonObject.getJSONArray("list");

            boolean idFound = false;

            // Get all webapi data and compare input with webapi's ids
            for (int i = 0; i < list.length(); i++) {
                JSONObject item = list.getJSONObject(i);
                String id = item.getString("id");
                String name = item.getString("name");
                String description = item.getString("description");
                String modelo = item.getString("modelo");

                if (text.equals(id)) {
                    TextView tvName = findViewById(R.id.tvProductName);
                    tvName.setEnabled(false);
                    tvName.setText(name);

                    TextView tvDesc = findViewById(R.id.tvProductDescription);
                    tvDesc.setEnabled(false);
                    tvDesc.setText(description);

                    TextView tvModel = findViewById(R.id.tvProductModel);
                    tvModel.setEnabled(false);
                    tvModel.setText(modelo);

                    idFound = true;
                    break; // If id is found, break cycle
                }
            }

            if (!idFound) {
                // If id isn`t found, clean name, description and model
                TextView tvName = findViewById(R.id.tvProductName);
                tvName.setEnabled(false);
                tvName.setText("");

                TextView tvDesc = findViewById(R.id.tvProductDescription);
                tvDesc.setEnabled(false);
                tvDesc.setText("");

                TextView tvModelo = findViewById(R.id.tvProductModel);
                tvModelo.setEnabled(false);
                tvModelo.setText("");

                Toast.makeText(ScanActivity.this, "Nenhum resultado encontrado no CRM.", Toast.LENGTH_SHORT).show();
            }

        } catch (JSONException e) {
            Log.e(TAG, "Error parsing JSON", e);
        }
    }
    private class AuthenticateAsyncTask extends AsyncTask<Void, Void, Boolean> {

        @Override
        protected Boolean doInBackground(Void... voids) {
            SSLAccess();
            HttpURLConnection connection = null;

            try {
                // API Connection
                URL url = new URL(API_URL);
                connection = (HttpURLConnection) url.openConnection();
                connection.setRequestMethod("GET");

                // Remove leading/trailing whitespace characters from the key
                String trimmedKey = KEY_ENCRYPTED_LOGIN.trim();

                // Define authentication header
                connection.setRequestProperty("Authorization", "Basic " + trimmedKey);

                // Submit connection and get connection`s response
                int responseCode = connection.getResponseCode();

                if (responseCode == HttpURLConnection.HTTP_OK) {
                    // If connection is successfully, get api info
                    StringBuilder stringBuilder = new StringBuilder();
                    BufferedReader reader = new BufferedReader(new InputStreamReader(connection.getInputStream()));
                    String line;
                    while ((line = reader.readLine()) != null) {
                        stringBuilder.append(line);
                    }
                    responseJson = stringBuilder.toString();
                }

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
                ScanActivity.this.isAuthenticated = true;
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
