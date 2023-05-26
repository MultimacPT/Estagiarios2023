package com.example.natura;

import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;


import android.annotation.SuppressLint;
import android.content.DialogInterface;
import android.content.Intent;
import android.os.Build;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;

public class Dashboard extends AppCompatActivity {

    TextView user;
    SessionManager sessionManager;
    Button lognout;

    @SuppressLint("MissingInflatedId")
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_dashboard);

        sessionManager = new SessionManager(getApplicationContext());


        user = findViewById(R.id.textView);
        lognout = findViewById(R.id.button);


        String sUsername = sessionManager.getusername();
        user.setText(sUsername);

        lognout.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                AlertDialog.Builder builder = new AlertDialog.Builder(v.getContext(), R.style.AlertDialogCustom);
                builder.setTitle("Logout");
                builder.setMessage("Tem a certeza que quer sair?");

                builder.setPositiveButton("Sim", new DialogInterface.OnClickListener() {
                    @Override
                    public void onClick(DialogInterface dialog, int which) {
                        sessionManager.setlogin(false);
                        sessionManager.setusername("");
                        startActivity(new Intent(getApplicationContext(), Login.class));
                        finish();
                    }
                });

                builder.setNegativeButton("Não", new DialogInterface.OnClickListener() {
                    @Override
                    public void onClick(DialogInterface dialog, int which) {
                        dialog.cancel();
                    }
                });

                AlertDialog alertDialog = builder.create();
                alertDialog.show();


// Obter os botões do AlertDialog
                Button positiveButton = alertDialog.getButton(DialogInterface.BUTTON_POSITIVE);
                Button negativeButton = alertDialog.getButton(DialogInterface.BUTTON_NEGATIVE);

// Definir cor do texto para "Sim" (vermelho)
                positiveButton.setTextColor(getResources().getColor(R.color.natura_color));

// Definir cor do texto para "Não" (vermelho)
                negativeButton.setTextColor(getResources().getColor(R.color.natura_color));

            }
        });






    }
}