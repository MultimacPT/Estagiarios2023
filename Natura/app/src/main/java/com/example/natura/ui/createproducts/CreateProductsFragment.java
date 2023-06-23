package com.example.natura.ui.createproducts;

import android.os.AsyncTask;
import android.os.Bundle;

import androidx.fragment.app.Fragment;

import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.Toast;

import com.example.natura.SessionManager;
import com.example.natura.databinding.FragmentCreateProductsBinding;

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

public class CreateProductsFragment extends Fragment {

    private FragmentCreateProductsBinding binding;

    private String KEY_ENCRYPTED_LOGIN = "";

    private SessionManager sessionManager;

    private ArrayList<String> productDescriptions;
    private ArrayList<String> productNames;

    private ArrayList<String> productIds;


    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        binding = FragmentCreateProductsBinding.inflate(inflater, container, false);
        View root = binding.getRoot();

        sessionManager = new SessionManager(getContext());

        KEY_ENCRYPTED_LOGIN = sessionManager.getEncryptedLogin();

        binding.btnCreateProduct.setOnClickListener(new View.OnClickListener() { //Create Product Button's Click Listener
            @Override
            public void onClick(View v) {
                String productName = binding.etProductName.getText().toString().trim();
                String description = binding.etProductDescription.getText().toString().trim();
                String model = binding.etProductModel.getText().toString().trim();

                if (!productName.isEmpty() && !description.isEmpty() && !model.isEmpty()) { //Form handling
                    int selectedIndex = binding.spinner.getSelectedItemPosition();
                    if (selectedIndex >= 0 && selectedIndex < productIds.size()) {
                        String selectedProductId = productIds.get(selectedIndex);
                        String selectedProductName = productNames.get(selectedIndex);

                        // Create product
                        new CreateProductsFragment.CreateProductTask().execute(productName, description, model, selectedProductName, selectedProductId);
                        binding.etProductName.setText("");
                        binding.etProductName.setHint("(Nome do Produto)");

                        binding.etProductDescription.setText("");
                        binding.etProductDescription.setHint("(Descrição do Produto)");

                        binding.etProductModel.setText("");
                        binding.etProductModel.setHint("(Modelo do Produto)");

                    } else {
                        Toast.makeText(getContext(), "ERRO! Selecione algum tipo de produto.", Toast.LENGTH_SHORT).show();
                    }
                } else {
                    Toast.makeText(getContext(), "ERRO! Preencha todos os campos.", Toast.LENGTH_SHORT).show();
                }
            }
        });

        new CreateProductsFragment.FetchProductsTask().execute();

        return root;
    }

    private class FetchProductsTask extends AsyncTask<Void, Void, JSONObject> { //Insert all web api's products on spinner.
        @Override
        protected JSONObject doInBackground(Void... params) {

            try {
                //Web api connection
                String trimmedKey = KEY_ENCRYPTED_LOGIN.trim();
                URL url = new URL("https://mx.multimac.pt/mxv5/api/v1/Product?select=brandId%2CbrandName%2Cname%2Cdescription%2Cfamilia&offset=0&orderBy=name&order=asc");
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
        protected void onPostExecute(JSONObject responseObject) { //Get web api's data
            if (responseObject != null) {
                try {
                    JSONArray productList = responseObject.getJSONArray("list");
                    productDescriptions = new ArrayList<>();
                    productNames = new ArrayList<>();
                    productIds = new ArrayList<>();
                    for (int i = 0; i < productList.length(); i++) {
                        JSONObject product = productList.getJSONObject(i);
                        String id = product.getString("id");
                        String name = product.getString("name");
                        String description = product.getString("description");
                        productDescriptions.add(description);
                        productNames.add(name);
                        productIds.add(id);
                    }

                    //Insert data on spinner
                    ArrayAdapter<String> adapter = new ArrayAdapter<>(getContext(), android.R.layout.simple_spinner_item, productDescriptions);
                    binding.spinner.setAdapter(adapter);
                } catch (JSONException e) {
                    e.printStackTrace();
                }
            } else {
                Toast.makeText(getContext(), "ERRO! Falha ao obter os tipos de produto.", Toast.LENGTH_SHORT).show();
            }
        }
    }

    private class CreateProductTask extends AsyncTask<String, Void, Boolean> { //Web api's post method, insert new products
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
                //TODO("Ir para o fragmento de produtos")
                Toast.makeText(getContext(), "Produto criado com sucesso!", Toast.LENGTH_SHORT).show();
            } else {
                Toast.makeText(getContext(), "ERRO! Falha ao criar o produto.", Toast.LENGTH_SHORT).show();
            }
        }
    }

    public void SSLAccess() { //Access to all SSL

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

    @Override
    public void onDestroyView() {
        super.onDestroyView();
        binding = null;
    }
}