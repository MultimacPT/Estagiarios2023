package com.example.natura;

import android.os.AsyncTask;
import android.os.Bundle;
import android.util.Log;
import android.view.KeyEvent;
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
import java.util.Base64;

import javax.net.ssl.HostnameVerifier;
import javax.net.ssl.HttpsURLConnection;
import javax.net.ssl.SSLContext;
import javax.net.ssl.TrustManager;
import javax.net.ssl.X509TrustManager;

public class scan extends AppCompatActivity {

    private static final String API_URL = "https://mx.multimac.pt/mxv5/api/v1/Consumiveisvsmodelo?select=productId%2CproductName%2Cmodelo%2Cdescription%2CcreatedById%2CcreatedByName%2CcreatedAt%2CmodifiedById%2CmodifiedByName%2CmodifiedAt%2Cname&maxSize=25&offset=0&orderBy=createdAt&order=desc";
    private static final String TAG = scan.class.getSimpleName();

    public static String KEY_ENCRYPTED_LOGIN = "";

    private String responseJson;

    SessionManager sessionManager;

    private boolean isAuthenticated = false; // Variável de controle

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_scan);

        sessionManager = new SessionManager(getApplicationContext());

        KEY_ENCRYPTED_LOGIN = sessionManager.getEncryptedLogin();

        // Faz a autenticação
        new AuthenticateAsyncTask().execute();
    }

    @Override
    public boolean dispatchKeyEvent(KeyEvent event) {
        int keyCode = event.getKeyCode();

        EditText editText = findViewById(R.id.editTextText);
        TextView textView = findViewById(R.id.TextText);
        textView.setEnabled(false);

        if (event.getAction() == KeyEvent.ACTION_DOWN && keyCode == KeyEvent.KEYCODE_ENTER) {
            // Armazenar o valor atual do EditText
            String texto = editText.getText().toString();

            // Definir o valor no campo de texto
            textView.setText(texto);

            // Limpar o conteúdo do EditText
            editText.setText("");

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

        return super.dispatchKeyEvent(event);
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

            // Percorrer a lista de objetos e comparar com o valor de "texto"
            for (int i = 0; i < list.length(); i++) {
                JSONObject item = list.getJSONObject(i);
                String id = item.getString("id");
                String name = item.getString("name");

                if (texto.equals(id)) {
                    TextView tvName = findViewById(R.id.tvProductName);
                    tvName.setEnabled(false);
                    tvName.setText(name);
                    return; // Encerrar a função assim que encontrar uma correspondência
                }
            }

            // Nenhum ID correspondente encontrado, mostrar uma mensagem adequada.
            Toast.makeText(scan.this, "Nenhum resultado encontrado.", Toast.LENGTH_SHORT).show();

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

                // Define o header de autenticação
                connection.setRequestProperty("Authorization", "Basic " + KEY_ENCRYPTED_LOGIN);

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
                scan.this.isAuthenticated = true;
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
