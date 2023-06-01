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
        TextView editText2 = findViewById(R.id.TextText);

        String texto = String.valueOf(editText.getText());
        editText2.setText(texto);


        return super.dispatchKeyEvent(event);
    }

    private void executarAcaoEnter() {
        EditText editText = findViewById(R.id.editTextText);
        String texto = "Texto inserido com a tecla Enter";
        editText.setText(texto);
    }
}