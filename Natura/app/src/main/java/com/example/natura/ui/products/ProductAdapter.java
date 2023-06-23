package com.example.natura.ui.products;

import android.app.AlertDialog;
import android.content.DialogInterface;
import android.graphics.Bitmap;
import android.graphics.Color;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import com.example.natura.R;
import com.google.zxing.BarcodeFormat;
import com.google.zxing.EncodeHintType;
import com.google.zxing.common.BitMatrix;
import com.google.zxing.oned.Code128Writer;

import java.util.HashMap;
import java.util.List;
import java.util.Map;

public class ProductAdapter extends RecyclerView.Adapter<ProductAdapter.ProductViewHolder> {

    private List<Product> productList;

    public ProductAdapter(List<Product> productList) {
        this.productList = productList;
    }

    @NonNull
    @Override
    public ProductViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        LayoutInflater inflater = LayoutInflater.from(parent.getContext());
        View view = inflater.inflate(R.layout.item_product, parent, false);
        return new ProductViewHolder(view);
    }

    @Override
    public void onBindViewHolder(@NonNull ProductViewHolder holder, int position) {
        Product product = productList.get(position);
        holder.bind(product);
    }

    @Override
    public int getItemCount() {
        return productList.size();
    }

    public static class ProductViewHolder extends RecyclerView.ViewHolder {

        private TextView txtName;
        private TextView txtDescription;
        private TextView txtModel;

        private Button btnShowId;

        public ProductViewHolder(@NonNull View itemView) {
            super(itemView);
            txtName = itemView.findViewById(R.id.txtName);
            txtDescription = itemView.findViewById(R.id.txtDescription);
            txtModel = itemView.findViewById(R.id.txtModel);
            btnShowId = itemView.findViewById(R.id.btnShowBarCode);
        }

        public void bind(Product product) {
            txtName.setText(product.getName());
            txtDescription.setText(product.getDescription());
            txtModel.setText(product.getModel());

            btnShowId.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    generateBarcodeCode128(product.getId());
                }
            });
        }

        private void generateBarcodeCode128(String productId) {
            Map<EncodeHintType, Object> hints = new HashMap<>();
            hints.put(EncodeHintType.CHARACTER_SET, "UTF-8");
            hints.put(EncodeHintType.MARGIN, 1);

            try {
                BitMatrix bitMatrix = new Code128Writer().encode(productId, BarcodeFormat.CODE_128, 800, 300, hints);

                int width = bitMatrix.getWidth();
                int height = bitMatrix.getHeight();
                Bitmap bitmap = Bitmap.createBitmap(width, height, Bitmap.Config.ARGB_8888);

                for (int x = 0; x < width; x++) {
                    for (int y = 0; y < height; y++) {
                        bitmap.setPixel(x, y, bitMatrix.get(x, y) ? Color.BLACK : Color.WHITE);
                    }
                }

                AlertDialog.Builder builder = new AlertDialog.Builder(itemView.getContext());
                View dialogView = LayoutInflater.from(itemView.getContext()).inflate(R.layout.dialog_image_preview, null);
                ImageView imageView = dialogView.findViewById(R.id.image_preview);
                imageView.setImageBitmap(bitmap);

                TextView txtId = dialogView.findViewById(R.id.txtProductId);
                txtId.setText(productId);

                builder.setView(dialogView)
                        .setPositiveButton("Fechar", new DialogInterface.OnClickListener() {
                            @Override
                            public void onClick(DialogInterface dialog, int which) {dialog.cancel();}
                        });

                AlertDialog dialog = builder.create();
                dialog.show();
            } catch (Exception e) {
                e.printStackTrace();
                Toast.makeText(itemView.getContext(), "Erro ao gerar o código de barras.", Toast.LENGTH_SHORT).show();
            }
        }

    }
}

