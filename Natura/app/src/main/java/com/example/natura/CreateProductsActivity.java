package com.example.natura;

import android.os.AsyncTask;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Spinner;
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
import java.util.ArrayList;

import javax.net.ssl.HostnameVerifier;
import javax.net.ssl.HttpsURLConnection;
import javax.net.ssl.SSLContext;
import javax.net.ssl.TrustManager;
import javax.net.ssl.X509TrustManager;

public class CreateProductsActivity extends AppCompatActivity {

    private Button btnCreateProduct;
    private EditText edtProductName;
    private EditText edtDescription;
    private EditText edtModel;
    private Spinner spinner;

    private String KEY_ENCRYPTED_LOGIN = "";

    private SessionManager sessionManager;
    private ArrayList<String> productNames;
    private ArrayList<String> productIds;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_create_products);

        sessionManager = new SessionManager(getApplicationContext());

        KEY_ENCRYPTED_LOGIN = sessionManager.getEncryptedLogin();

        btnCreateProduct = findViewById(R.id.btnCreateProduct);
        edtProductName = findViewById(R.id.etProductName);
        edtDescription = findViewById(R.id.etProductDescription);
        edtModel = findViewById(R.id.etProductModel);
        spinner = findViewById(R.id.spinner);

        btnCreateProduct.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                String productName = edtProductName.getText().toString().trim();
                String description = edtDescription.getText().toString().trim();
                String model = edtModel.getText().toString().trim();

                if (!productName.isEmpty() && !description.isEmpty()) {
                    int selectedIndex = spinner.getSelectedItemPosition();
                    if (selectedIndex >= 0 && selectedIndex < productIds.size()) {
                        String productId = productIds.get(selectedIndex);
                        String selectedProductName = productNames.get(selectedIndex);
                        new CreateProductTask().execute(productName, description, model, selectedProductName, productId);
                    } else {
                        Toast.makeText(CreateProductsActivity.this, "Please select a product", Toast.LENGTH_SHORT).show();
                    }
                } else {
                    Toast.makeText(CreateProductsActivity.this, "Please enter product name and description", Toast.LENGTH_SHORT).show();
                }
            }
        });

        new FetchProductsTask().execute();
    }

    private class FetchProductsTask extends AsyncTask<Void, Void, JSONObject> {
        @Override
        protected JSONObject doInBackground(Void... params) {

            try {
                String trimmedKey = KEY_ENCRYPTED_LOGIN.trim();
                URL url = new URL("https://mx.multimac.pt/mxv5/api/v1/Product?select=brandId%5E%25%5E2CbrandName%5E%25%5E2Cname%5E%25%5E2Cdescription%5E%25%5E2Cfamilia&maxSize=25&offset=0&orderBy=name&order=asc");
                SSLAccess();
                HttpURLConnection connection = (HttpURLConnection) url.openConnection();
                connection.setRequestMethod("GET");
                connection.setRequestProperty("Accept", "application/json, text/javascript, */*; q=0.01");
                connection.setRequestProperty("Accept-Language", "pt-PT,pt;q=0.9,en-US;q=0.8,en;q=0.7");
                connection.setRequestProperty("Authorization", "Basic " + trimmedKey);

                int responseCode = connection.getResponseCode();
                if (responseCode == HttpURLConnection.HTTP_OK) {
                    BufferedReader bufferedReader = new BufferedReader(new InputStreamReader(connection.getInputStream()));
                    StringBuilder response = new StringBuilder();
                    String line;
                    while ((line = bufferedReader.readLine()) != null) {
                        response.append(line);
                    }
                    bufferedReader.close();

                    return new JSONObject(response.toString());
                } else {
                    Log.e("Response Code", String.valueOf(responseCode));
                    return null;
                }
            } catch (IOException | JSONException e) {
                e.printStackTrace();
                return null;
            }
        }

        @Override
        protected void onPostExecute(JSONObject responseObject) {
            if (responseObject != null) {
                try {
                    JSONArray productList = responseObject.getJSONArray("list");
                    productNames = new ArrayList<>();
                    productIds = new ArrayList<>();
                    for (int i = 0; i < productList.length(); i++) {
                        JSONObject product = productList.getJSONObject(i);
                        String id = product.getString("id");
                        String name = product.getString("name");
                        productNames.add(name);
                        productIds.add(id);
                    }
                    ArrayAdapter<String> adapter = new ArrayAdapter<>(CreateProductsActivity.this, android.R.layout.simple_spinner_item, productNames);
                    spinner.setAdapter(adapter);
                } catch (JSONException e) {
                    e.printStackTrace();
                }
            } else {
                Toast.makeText(CreateProductsActivity.this, "Failed to fetch products", Toast.LENGTH_SHORT).show();
            }
        }
    }

    private class CreateProductTask extends AsyncTask<String, Void, Boolean> {
        @Override
        protected Boolean doInBackground(String... params) {
            try {
                String productName = params[0];
                String description = params[1];
                String model = params[2];
                String selectedProductName = params[3];
                String productId = params[4];

                String trimmedKey = KEY_ENCRYPTED_LOGIN.trim();

                URL url = new URL("https://mx.multimac.pt/mxv5/api/v1/Consumiveisvsmodelo?select=productId%2CproductName%2Cmodelo%2Cdescription%2CcreatedById%2CcreatedByName%2CcreatedAt%2CmodifiedById%2CmodifiedByName%2CmodifiedAt%2Cname&maxSize=25&offset=0&orderBy=createdAt&order=desc");
                SSLAccess();
                HttpURLConnection connection = (HttpURLConnection) url.openConnection();
                connection.setRequestMethod("POST");
                connection.setRequestProperty("Accept", "application/json, text/javascript, */*; q=0.01");
                connection.setRequestProperty("Accept-Language", "pt-PT,pt;q=0.9,en-US;q=0.8,en;q=0.7");
                connection.setRequestProperty("Content-Type", "application/json");
                connection.setRequestProperty("Authorization", "Basic " + trimmedKey);
                connection.setDoOutput(true);

                String requestBody = "{\n\t\t\t\"id\": \"\",\n\t\t\t\"name\": \"" + productName + "\",\n\t\t\t\"description\": \"" + description + "\",\n\t\t\t\"createdAt\": \"\",\n\t\t\t\"modifiedAt\": \"\",\n\t\t\t\"modelo\": \"" + model + "\",\n\t\t\t\"createdById\": \"\",\n\t\t\t\"createdByName\": \"\",\n\t\t\t\"modifiedById\": \"\",\n\t\t\t\"modifiedByName\": \"\",\n\t\t\t\"assignedUserId\": \"null\",\n\t\t\t\"productId\": \"" + productId + "\",\n\t\t\t\"productName\": \"" + selectedProductName + "\"\n\t\t}";
                connection.getOutputStream().write(requestBody.getBytes());
                connection.getOutputStream().flush();
                connection.getOutputStream().close();

                int responseCode = connection.getResponseCode();
                if (responseCode == HttpURLConnection.HTTP_OK) {
                    BufferedReader bufferedReader = new BufferedReader(new InputStreamReader(connection.getInputStream()));
                    StringBuilder response = new StringBuilder();
                    String line;
                    while ((line = bufferedReader.readLine()) != null) {
                        response.append(line);
                    }
                    bufferedReader.close();

                    Log.d("Response", response.toString());
                    return true;
                } else {
                    Log.e("Response Code", String.valueOf(responseCode));
                    return false;
                }
            } catch (Exception e) {
                e.printStackTrace();
                return false;
            }
        }

        @Override
        protected void onPostExecute(Boolean result) {
            if (result) {
                Toast.makeText(CreateProductsActivity.this, "Product created successfully", Toast.LENGTH_SHORT).show();
            } else {
                Toast.makeText(CreateProductsActivity.this, "Failed to create product", Toast.LENGTH_SHORT).show();
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