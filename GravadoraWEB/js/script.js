function gerarHtmlCD(arr){
    var str =  "<div class='cdblock'><img class='cdb_img' src='img/capas/"+ arr.codigo_cd +".jpg' alt=''><div class='cdb_title'>"+ arr.titulo +"</div><div class='cdb_artist'>" + arr.nome + "</div><div class='cdb_lancamento'>("+arr.data_lancamento+")</div><div class='cdb_acoes'><a href='editarcd.php?codigo="+arr.codigo_cd+"'>Editar</a> | <a href='removercd.php?codigo="+arr.codigo_cd+"'>Remover</a></div></div></div>";
    return str;
}

function pesquisa_ajax(){
    var filtro = $("#filtro_select").val();
    var pesquisa = $("#pesquisainput").val();
        $.ajax({
            url : "request.php?pesquisa="+ pesquisa + "&filtro=" + filtro,
        // dataType json
            dataType : "json",
        // função para de sucesso
            success : function(data){
            // vamos gerar um html e guardar nesta variável
                var html = "";
     
            // executo este laço para ecessar os itens do objeto javaScript
                
                if(data.length > 0){
                    for($i=0; $i < data.length; $i++){
                    // coloco o nome e sobre nome
                        //html += "<strong>Nome:</strong> "+data[$i].titulo;
                        html += gerarHtmlCD(data[$i]);
                    }//fim do laço
                }else{
                    html += "<h5>Nenhum resultado para essa pesquisa.</h5>";
                }
     
                //coloco a variável html na tela
                $('#listagemcd').html(html);
            },
            error: function (textStatus, errorThrown) {
                //console.log(textStatus);
            }
        });//termina o ajax
}


$(document).ready(function() {
    $("#pesquisainput").keyup(function(event) {
        pesquisa_ajax();
    });
    $("#filtro_select").change(function(event) {
        pesquisa_ajax();
    });

    $("#removecdbtn").click(function(event) {
        if(confirm("Deseja realmente remover este CD?")){
            $("#removecd").submit();
        }
    });
});//termina o jquery