// criar a div principal da barra de navegação
var navbarDiv = document.createElement("div");
navbarDiv.setAttribute("data-role", "navbar");

// criar a lista ul para conter os links
var linkList = document.createElement("ul");

// criar o primeiro link
var relatorioLink = document.createElement("li");
var relatorioHref = document.createElement("a");
relatorioHref.setAttribute("href", "relatorio-layout.php");
relatorioHref.innerHTML = "Relatório";
relatorioLink.appendChild(relatorioHref);

// criar o segundo link ativo
var picagemLink = document.createElement("li");
var picagemHref = document.createElement("a");
picagemHref.setAttribute("href", "picagem-layout.php");
picagemHref.setAttribute("class", "ui-btn-active");
picagemHref.innerHTML = "Picagem";
picagemLink.appendChild(picagemHref);

// criar o terceiro link
var perfilLink = document.createElement("li");
var perfilHref = document.createElement("a");
perfilHref.setAttribute("href", "perfil-layout.php");
perfilHref.innerHTML = "Perfil";
perfilLink.appendChild(perfilHref);

// adicionar os links à lista ul
linkList.appendChild(relatorioLink);
linkList.appendChild(picagemLink);
linkList.appendChild(perfilLink);

// adicionar a lista ul à div da barra de navegação
navbarDiv.appendChild(linkList);

// adicionar a div da barra de navegação à página
document.body.appendChild(navbarDiv);