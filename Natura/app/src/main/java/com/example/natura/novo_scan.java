package com.example.natura;

import androidx.appcompat.app.AppCompatActivity;

import android.os.Bundle;
import android.view.KeyEvent;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

public class novo_scan extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_novo_scan);
    }


    @Override
    public boolean dispatchKeyEvent(KeyEvent event) {
        int keyCode = event.getKeyCode();
        Toast.makeText(this, "Tecla pressionada: " + keyCode, Toast.LENGTH_SHORT).show();

        EditText editText2 = findViewById(R.id.editTextText2);

        TextView textView2 = findViewById(R.id.TextText2);
        textView2.setEnabled(false);

        if (event.getAction() == KeyEvent.ACTION_DOWN && keyCode == KeyEvent.KEYCODE_ENTER) {
            // Armazenar o valor atual do EditText
            String texto2 = editText2.getText().toString();

            // Definir o valor no campo de texto
            textView2.setText(texto2);

            // Limpar o conteúdo do EditText
            editText2.setText("");
        }

        return super.dispatchKeyEvent(event);
    }





}