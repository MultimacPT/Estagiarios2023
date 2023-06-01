package com.example.natura;

import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;


import android.annotation.SuppressLint;
import android.content.DialogInterface;
import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;

public class Dashboard extends AppCompatActivity {

    TextView user;
    TextView id;
    TextView email;
    TextView phone;
    SessionManager sessionManager;
    Button logout,scan;

    @SuppressLint("MissingInflatedId")
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_dashboard);

        sessionManager = new SessionManager(getApplicationContext());


        user = findViewById(R.id.tvUsername);
        id = findViewById(R.id.tvId);
        email = findViewById(R.id.tvEmail);
        phone = findViewById(R.id.tvPhone);
        logout = findViewById(R.id.button);
        scan = findViewById(R.id.button1);



        String sUsername = sessionManager.getUsername();
        user.setText(sUsername);

        String sId = sessionManager.getId();
        id.setText(sId);

        String sEmail = sessionManager.getEmail();
        email.setText(sEmail);

        String sPhone = sessionManager.getPhone();
        phone.setText(sPhone);


        scan.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                startActivity(new Intent(getApplicationContext(), scan.class));
                finish();

            }
        });

        logout.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                AlertDialog.Builder builder = new AlertDialog.Builder(v.getContext(), R.style.AlertDialogCustom);
                builder.setTitle("Logout");
                builder.setMessage("Tem a certeza que quer sair?");

                builder.setPositiveButton("Sim", new DialogInterface.OnClickListener() {
                    @Override
                    public void onClick(DialogInterface dialog, int which) {
                        sessionManager.setLogin(false);
                        sessionManager.setUsername("");
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