$(document).ready(function(){
    
    $("#chiudi-preview-foto-profilo").on("click",function(){
        $("#preview-foto-profilo").hide();
    });
    $("#chiudi-preview-banner-profilo").on("click",function(){
        $("#preview-banner-profilo").hide();
    });

    //parte della foto di profilo
    $image_crop_profilo = $('#ritaglio-immagine-profilo').croppie({
        enableExif: true,
        viewport: {
          width:200,
          height:200,
          type:'circle' 
        },
        boundary:{
          width:300,
          height:300
        }
      });

      $('#immagine_foto_profilo').on('change', function(){
        $("#preview-foto-profilo").show();
        var reader = new FileReader();
        reader.onload = function (event) {
          $image_crop_profilo.croppie('bind', {
            url: event.target.result
          }).then(function(){});
        }
        reader.readAsDataURL(this.files[0]);
        
      });
      
      $('#pulsante_conferma_ritaglio_foto_profilo').click(function(event){
        event.preventDefault(); 
        $image_crop_profilo.croppie('result', {
          type: 'canvas',
          size: 'viewport'
        }).then(function(response){
            $.ajax({
                url:"../../php/caricamentoFotoProfilo.php",
                type: "POST",
                data:{"immagine": response},
                success:function(data)
                {
                    $("#preview-foto-profilo").hide();
                    if(data == "error1"){
                        alert("la foto non è stata modificata,perfavore riprova");
                    }else if(data == "error2"){
                        alert("la foto deve essere inferiore ai 10Mb");
                    }else{
                        document.querySelector('#immagine_profilo').style.backgroundImage = "url('../../uploads/"+data+"')" ;
                    }
                }
              });
        })
      });


      //parte del banner


      $image_crop_banner = $('#ritaglio-banner-profilo').croppie({
        enableExif: true,
        viewport: { width: 900, height: 350 },
        boundary: { width: 900, height: 380 },
        showZoomer: false,
        enableOrientation: true
      });

      $('#immagine_banner').on('change', function(){
        $("#preview-banner-profilo").show();
        var reader_banner = new FileReader();
        reader_banner.onload = function (event) {
          $image_crop_banner.croppie('bind', {
            url: event.target.result
          }).then(function(){});
        }
        reader_banner.readAsDataURL(this.files[0]);
        
      });
      
      $('#pulsante_conferma_ritaglio_banner_profilo').click(function(event){
        event.preventDefault(); 
        $image_crop_banner.croppie('result', {
          type: 'canvas',
          size: 'original',
          quality: 1
        }).then(function(response){
            $.ajax({
                url:"../../php/caricamentoBannerProfilo.php",
                type: "POST",
                data:{"immagine": response},
                success:function(data)
                {
                    $("#preview-banner-profilo").hide();
                    if(data == "error1"){
                        alert("la foto non è stata modificata,perfavore riprova");
                    }else if(data == "error2"){
                        alert("la foto deve essere inferiore ai 10Mb");
                    }else{
                        document.querySelector('#tag_immagine_banner').src = "../../uploads/"+data;
                    }
                }
              });
        })
      });
    
    
});



function triggerImmagineBanner(){
    document.querySelector("#immagine_banner").click();
}
function triggerImmagineFotoProfilo(){
    document.querySelector("#immagine_foto_profilo").click();
}