package com.example.natura.ui.products;

public class Product {
    private String id;
    private String name;
    private String description;
    private String model;

    public Product(String id, String name, String description, String model) {
        this.id = id;
        this.name = name;
        this.description = description;
        this.model = model;
    }

    public String getId() {
        return id;
    }

    public String getName() {
        return name;
    }

    public String getDescription() {
        return description;
    }

    public String getModel() {
        return model;
    }
}

