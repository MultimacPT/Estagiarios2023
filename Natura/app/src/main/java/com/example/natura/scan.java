package com.example.natura;

import android.os.AsyncTask;
import android.os.Bundle;
import android.view.KeyEvent;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.IOException;

import okhttp3.OkHttpClient;
import okhttp3.Request;
import okhttp3.Response;

public class scan extends AppCompatActivity {

    SessionManager sessionManager;

    OkHttpClient client = new OkHttpClient();

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_scan);

        sessionManager = new SessionManager(getApplicationContext());
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

            new ApiCallTask().execute(texto);

            // Limpar o conteúdo do EditText
            editText.setText("");
        }

        return super.dispatchKeyEvent(event);
    }

    //A partir daqui o programa da crash:

    private class ApiCallTask extends AsyncTask<String, Void, String> {

        private String texto;
        private Response response;

        @Override
        protected String doInBackground(String... params) {
            texto = params[0];
            String encryptedLogin = sessionManager != null ? sessionManager.getEncryptedLogin() : null;

            if (encryptedLogin == null) {
                return null;
            }

            Request request = new Request.Builder()
                    .url("https://mx.multimac.pt/mxv5/api/v1/Consumiveisvsmodelo?select=productId%2CproductName%2Cmodelo%2Cdescription%2CcreatedById%2CcreatedByName%2CcreatedAt%2CmodifiedById%2CmodifiedByName%2CmodifiedAt%2Cname&maxSize=25&offset=0&orderBy=createdAt&order=desc")
                    .addHeader("Accept", "application/json, text/javascript, */*; q=0.01")
                    .addHeader("Accept-Language", "pt-PT,pt;q=0.9,en-US;q=0.8,en;q=0.7")
                    .addHeader("Authorization", encryptedLogin) //a variavel está correta
                    .build();

            // Código insomnia:
            //HttpResponse<String> response = Unirest.get("https://mx.multimac.pt/mxv5/api/v1/Consumiveisvsmodelo?select=productId%2CproductName%2Cmodelo%2Cdescription%2CcreatedById%2CcreatedByName%2CcreatedAt%2CmodifiedById%2CmodifiedByName%2CmodifiedAt%2Cname&maxSize=25&offset=0&orderBy=createdAt&order=desc")
            //        .header("Accept", "application/json, text/javascript, */*; q=0.01")
            //        .header("Accept-Language", "pt-PT,pt;q=0.9,en-US;q=0.8,en;q=0.7")
            //        .header("Authorization", "Basic YWZpZ3VlaXJlZG86R1cyMmJVMmd1SA==")
            //        .asString();


            try {
                response = client.newCall(request).execute();
                if (response.isSuccessful()) {
                    return response.body().string();
                } else {
                    return null;
                }
            } catch (IOException e) {
                e.printStackTrace();
                return null;
            } finally {
                if (response != null && response.body() != null) {
                    response.body().close();
                }
            }
        }

        @Override
        protected void onPostExecute(String responseBody) {
            if (responseBody != null) {
                try {
                    JSONObject json = new JSONObject(responseBody);
                    JSONArray productList = json.optJSONArray("list");

                    if (productList != null) {
                        for (int i = 0; i < productList.length(); i++) {
                            JSONObject product = productList.getJSONObject(i);
                            String productId = product.getString("id");
                            String productName = product.getString("name");

                            if (productId.equals(texto)) {
                                showToast("Nome do produto: " + productName);
                                return;
                            }
                        }
                    }

                    showToast("Produto não encontrado");
                } catch (JSONException e) {
                    showToast("Erro ao analisar a resposta da API");
                    e.printStackTrace();
                }
            } else {
                showToast("Erro na solicitação");
            }
        }
    }




    private void showToast(String message) {
        Toast.makeText(getApplicationContext(), message, Toast.LENGTH_SHORT).show();
    }
}
