package com.example.natura;

import androidx.appcompat.app.AppCompatActivity;

import android.os.Bundle;
import android.view.KeyEvent;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

public class scan extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_scan);
    }
    @Override
    public boolean dispatchKeyEvent(KeyEvent event) {
        int keyCode = event.getKeyCode();
        Toast.makeText(scan.this, "Tecla pressionada: " + keyCode, Toast.LENGTH_SHORT).show();
        EditText editText = findViewById(R.id.editTextText);
        TextView textView = findViewById(R.id.TextText);

        if (event.getAction() == KeyEvent.ACTION_DOWN) {
            // Verifica se a tecla pressionada foi "ENTER"
            if (keyCode == KeyEvent.KEYCODE_ENTER) {
                String texto = editText.getText().toString();

                // Limpa o conteúdo do EditText
                editText.setText("");

                textView.setText(texto);

                return true; // Retorna true para indicar que o evento foi tratado
            }

        }
        return super.dispatchKeyEvent(event);
    }









    private void executarAcaoEnter() {
        EditText editText = findViewById(R.id.editTextText);
        String texto = "Texto inserido com a tecla Enter";
        editText.setText(texto);
    }
}