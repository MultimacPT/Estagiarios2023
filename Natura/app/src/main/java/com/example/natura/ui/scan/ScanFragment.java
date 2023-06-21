package com.example.natura.ui.scan;

import android.os.AsyncTask;
import android.os.Bundle;
import android.util.Log;
import android.view.KeyEvent;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

import androidx.annotation.NonNull;
import androidx.fragment.app.Fragment;

import com.example.natura.R;
import com.example.natura.SessionManager;
import com.example.natura.databinding.FragmentScanBinding;
import com.example.natura.scan;

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

public class ScanFragment extends Fragment {

    private FragmentScanBinding binding;

    private static final String API_URL = "https://mx.multimac.pt/mxv5/api/v1/Consumiveisvsmodelo?select=productId%2CproductName%2Cmodelo%2Cdescription%2CcreatedById%2CcreatedByName%2CcreatedAt%2CmodifiedById%2CmodifiedByName%2CmodifiedAt%2Cname&maxSize=25&offset=0&orderBy=createdAt&order=desc";
    private static final String TAG = scan.class.getSimpleName();

    public static String KEY_ENCRYPTED_LOGIN = "";

    private String responseJson;

    SessionManager sessionManager;

    private boolean isAuthenticated = false; // Variável de controle

    //dispatchKeyEvent aqui ou no navigationactivity que volta pra aq direto e passa as informações

    public View onCreateView(@NonNull LayoutInflater inflater,
                             ViewGroup container, Bundle savedInstanceState) {

        binding = FragmentScanBinding.inflate(inflater, container, false);
        View root = binding.getRoot();

        // Configurar o KeyListener para o EditText
        binding.etInput.setOnKeyListener(new View.OnKeyListener() {
            @Override
            public boolean onKey(View v, int keyCode, KeyEvent event) {
                if (event.getAction() == KeyEvent.ACTION_DOWN && keyCode == KeyEvent.KEYCODE_ENTER) {
                    // Armazenar o valor atual do EditText
                    String texto = binding.etInput.getText().toString();

                    // Definir o valor no campo de texto
                    binding.tvProductId.setText("ID: " + texto);

                    // Limpar o conteúdo do EditText
                    binding.etInput.setText("");

                    // Verificar se já foi autenticado
                    if (!isAuthenticated) {
                        // Faz a autenticação
                        new AuthenticateAsyncTask().execute();
                        return true; // Retorna sem processar o texto neste momento
                    }

                    // Verificar o texto
                    verifyText(texto);

                    return true;
                }
                return false;
            }
        });

        sessionManager = new SessionManager(getContext());

        KEY_ENCRYPTED_LOGIN = sessionManager.getEncryptedLogin();

        // Faz a autenticação
        new ScanFragment.AuthenticateAsyncTask().execute();


        return root;
    }

    private void verifyText(String texto) {
        // Verifique o texto aqui e implemente a lógica necessária
        // para comparar com os valores retornados pela API
        // e exibir o Toast correspondente.

        if (texto.isEmpty()) {
            // O texto está vazio, retorne ou mostre uma mensagem de erro, se necessário.
            return;
        }

        try {
            // Parse do JSON retornado pela API
            JSONObject jsonObject = new JSONObject(responseJson);
            JSONArray list = jsonObject.getJSONArray("list");

            boolean idEncontrado = false;

            // Percorrer a lista de objetos e comparar com o valor de "texto"
            for (int i = 0; i < list.length(); i++) {
                JSONObject item = list.getJSONObject(i);
                String id = item.getString("id");
                String name = item.getString("name");
                String description = item.getString("description");
                String model = item.getString("modelo");

                if (texto.equals(id)) {
                    binding.tvProductName.setEnabled(false);
                    binding.tvProductName.setText("Nome: " + name);

                    binding.tvProductDescription.setEnabled(false);
                    binding.tvProductDescription.setText("Descrição: " + description);

                    binding.tvProductModel.setEnabled(false);
                    binding.tvProductModel.setText("Modelo: " + model);

                    idEncontrado = true;
                    break; // Encerrar o loop assim que encontrar uma correspondência
                }
            }

            if (!idEncontrado) {
                // Nenhum ID correspondente encontrado, deixar o tvProductName vazio
                binding.tvProductName.setEnabled(false);
                binding.tvProductName.setText("");

                binding.tvProductDescription.setEnabled(false);
                binding.tvProductDescription.setText("");

                binding.tvProductModel.setEnabled(false);
                binding.tvProductModel.setText("");

                Toast.makeText(getContext(), "Nenhum resultado encontrado no CRM.", Toast.LENGTH_SHORT).show();
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
                // Cria a conexão com a API
                URL url = new URL(API_URL);
                connection = (HttpURLConnection) url.openConnection();
                connection.setRequestMethod("GET");

                // Remove leading/trailing whitespace characters from the key
                String trimmedKey = KEY_ENCRYPTED_LOGIN.trim();

                // Define o header de autenticação
                connection.setRequestProperty("Authorization", "Basic " + trimmedKey);

                // Faz a requisição e verifica a resposta
                int responseCode = connection.getResponseCode();

                if (responseCode == HttpURLConnection.HTTP_OK) {
                    // Se a autenticação foi bem-sucedida, obter a resposta da API
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
                // Marca como autenticado
                ScanFragment.this.isAuthenticated = true;
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

    @Override
    public void onDestroyView() {
        super.onDestroyView();
        binding = null;
    }
}