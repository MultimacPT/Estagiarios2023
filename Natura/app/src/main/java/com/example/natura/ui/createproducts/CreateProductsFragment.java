package com.example.natura.ui.createproducts;

import android.os.Bundle;

import androidx.fragment.app.Fragment;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;

import com.example.natura.R;
import com.example.natura.databinding.FragmentCreateProductsBinding;
import com.example.natura.databinding.FragmentScanBinding;

public class CreateProductsFragment extends Fragment {

    private FragmentCreateProductsBinding binding;

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        binding = FragmentCreateProductsBinding.inflate(inflater, container, false);
        View root = binding.getRoot();


        return root;
    }

    @Override
    public void onDestroyView() {
        super.onDestroyView();
        binding = null;
    }
}