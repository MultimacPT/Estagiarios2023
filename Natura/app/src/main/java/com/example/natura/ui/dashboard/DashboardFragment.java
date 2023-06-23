package com.example.natura.ui.dashboard;

import android.content.DialogInterface;
import android.content.Intent;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AlertDialog;
import androidx.fragment.app.Fragment;

import com.example.natura.Login;
import com.example.natura.R;
import com.example.natura.SessionManager;
import com.example.natura.databinding.FragmentDashboardBinding;

public class DashboardFragment extends Fragment {

    private FragmentDashboardBinding binding;

    SessionManager sessionManager;

    public View onCreateView(@NonNull LayoutInflater inflater,
                             ViewGroup container, Bundle savedInstanceState) {

        binding = FragmentDashboardBinding.inflate(inflater, container, false);
        View root = binding.getRoot();

        sessionManager = new SessionManager(getContext());

        //Set Username textview's text
        String sUsername = sessionManager.getUsername();
        binding.tvUsername.setText(sUsername);

        //Set ID textview's text
        String sId = sessionManager.getId();
        binding.tvId.setText(sId);

        //Set Email's textview's text
        String sEmail = sessionManager.getEmail();
        binding.tvEmail.setText(sEmail);

        //Set Phone's textview's text
        String sPhone = sessionManager.getPhone();
        binding.tvPhone.setText(sPhone);

        binding.btnLogout.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                AlertDialog.Builder builder = new AlertDialog.Builder(v.getContext(), R.style.AlertDialogCustom);
                builder.setTitle("Logout");
                builder.setMessage("Tem a certeza que quer sair?");

                builder.setPositiveButton("Sim", new DialogInterface.OnClickListener() { //Current user logout
                    @Override
                    public void onClick(DialogInterface dialog, int which) {
                        sessionManager.setLogin(false);
                        sessionManager.setUsername("");
                        startActivity(new Intent(getActivity(), Login.class));
                        getActivity().finish();
                    }
                });

                builder.setNegativeButton("Não", new DialogInterface.OnClickListener() { //Cancel dialog
                    @Override
                    public void onClick(DialogInterface dialog, int which) {
                        dialog.cancel();
                    }
                });

                AlertDialog alertDialog = builder.create();
                alertDialog.show();


                // Obtain alertDialog's buttons
                Button positiveButton = alertDialog.getButton(DialogInterface.BUTTON_POSITIVE);
                Button negativeButton = alertDialog.getButton(DialogInterface.BUTTON_NEGATIVE);

                // Set "Sim" text color
                positiveButton.setTextColor(getResources().getColor(R.color.natura_color));

                // Set "Não" text color
                negativeButton.setTextColor(getResources().getColor(R.color.natura_color));

            }
        });

        return root;
    }

    @Override
    public void onDestroyView() {
        super.onDestroyView();
        binding = null;
    }
}