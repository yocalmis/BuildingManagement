<?php  $this->load->view('header_ozel.php'); ?>	
<link rel="stylesheet" href="<?php echo base_url('assets/grocery_crud/css/ui/simple') ?>/jquery-ui-1.10.1.custom.min.css">



<body>
<?php 	        if( $data["fatura_getir_duzenle"] ) :  foreach( $data["fatura_getir_duzenle"] as $dizi_fat ) : $irs_durum=$dizi_fat["irsaliye_durum"]; $fat_id=$dizi_fat["id"]; $iade_fat=$dizi_fat["iade_fat"]; ?>


		<div class="material-container">

			<h2 class="material-container__heading">



		<form action="<?php echo base_url(); ?>yonetim/iade/<?php echo $dizi_fat["id"]; ?>" method="post" >
	
	<?php if($data['side_menu']=="Satış Fatura Ayarları"){ 

        if($iade_fat!=0){echo'Satış İade Faturası (İade Edilen Fatura)'; }
        else{ echo'Satış Faturası';  }

		 if($dizi_fat["iade_fat"]==0){ 
		echo ' <div style="float:right;"><input type="submit" value="İADE AL"/>';
		echo ' <input type="hidden" name="iade" value="iade_al" value="İADE AL"/></div>';
	 		} 	
	} ?>
	<?php if($data['side_menu']=="Alış Fatura Ayarları"){ 

        if($iade_fat!=0){echo'Alış İade Faturası (İadesi Yapılan Fatura <a href="'.base_url().'yonetim/fatura_goruntule/'.$iade_fat.'">Görüntüle</a>)'; }
        else{ echo'Alış Faturası';  }


	 if($dizi_fat["iade_fat"]==0){
		echo '<div style="float:right;"><input type="submit" value="İADE ET"/>';
		echo ' <input type="hidden" name="iade" value="iade_et" value="İADE AL"/></div>';
} 


	}   ?>		
			
		</form>
		
			</h2>

	<form action="<?php echo base_url(); ?>yonetim/fatura_guncelle" method="post" >

			<div class="material-container__row musteri_bilgi">
				
	<?php if($data['side_menu']=="Satış Fatura Ayarları"){ echo'<input id="fat_turu" name="fat_turu" value="Satış" type="hidden" placeholder="Fatura Türü" class="material-container__input" />'; } ?>
	<?php if($data['side_menu']=="Alış Fatura Ayarları"){ echo'<input id="fat_turu" name="fat_turu" value="Alış" type="hidden" placeholder="Fatura Türü" class="material-container__input" />'; } ?>		
				
				<select id="mus" name="mus" required placeholder="Müşteri" class="material-container__input">
<option selected value="<?php echo $c_id=$dizi_fat["cari_id"]; ?>"><?php echo $c_ad=$data["cari_ad"]; ?></option>

			</select>
				<!--	<input id="mus" name="mus" type="text" required placeholder="Müşteri" class="material-container__input" />-->
					
					
	
					
					
					
					
					<input  id="seri" name="seri" type="text" value="<?php $fat_id=$dizi_fat["id"]; echo $dizi_fat["seri_no"]; ?>" required placeholder="Seri No" class="material-container__input" />
					<input  id="no" name="no" type="text" required value="<?php echo $dizi_fat["fatura_no"]; ?>" placeholder="Fatura No" class="material-container__input" />
						<input 
							id="duz_ta" 
							name="duz_ta" 
							value="<?php $parca=explode("-",$dizi_fat["tarih"]); echo $parca[1]."/".$parca[2]."/".$parca[0]; ?>"
							type="text"  required
							placeholder="Düzenleme Tarihi" 
							class="material-container__input datepicke" />
						<input 
							id="va_ta" 
							name="va_ta" 
							value="<?php $parca=explode("-",$dizi_fat["vade_tarihi"]); echo $parca[1]."/".$parca[2]."/".$parca[0]; ?>"
							type="text"  required
							placeholder="Vade Tarihi" 
							class="material-container__input datepicke" />
				


			</div>
			<div class="material-container__row">
				<input id="ack" name="ack" type="text"  required placeholder="Açıklama" value="<?php echo $dizi_fat["aciklama"]; ?>" style="width: 100%" class="material-container__input" />
					
			</div>
	<?php 	    $n=0;    if( $data["fatura_item_getir_duzenle"] ) :  foreach( $data["fatura_item_getir_duzenle"] as $dizi ) : ?>
			<div class="material-container__row fatura_row item">
				<div class="fatura_row__genel-bilgi">
				<!--	<input id="item" type="text" name="item_1"  required placeholder="Ürün/Hizmet #1" class="material-container__input" />-->
					
					
					
						<select id="item"  name="item_<?php echo $n+1; ?>"  required placeholder="Ürün/Hizmet #1" class="material-container__input" >
						
			<option selected value="<?php echo $dizi["hizmet_urun_id"]; ?>"><?php echo $data["urun_ad"][$n]; ?></option>												
			</select>	
					
					
					<input  id="des" type="text" name="des_<?php echo $n+1; ?>" value="<?php echo $dizi["aciklama"]; ?>"   placeholder="Açıklama" class="material-container__input" />

				</div>
				<div class="fatura_row__genel-veriler">
					<input id="pr" type="number" name="prc_<?php echo $n+1; ?>" value="<?php echo $dizi["birim_fiyat"]; ?>"  required min="0" placeholder="Fiyat" class="material-container__input urunInput" />
					<input id="qt" type="number" name="qty_<?php echo $n+1; ?>" value="<?php echo $dizi["adet"]; ?>"  required min="0" placeholder="Miktar" class="material-container__input urunInput" />
					<input id="dis" type="number" name="discount_<?php echo $n+1; ?>" value="<?php echo $dizi["indirim"]; ?>"  required min="0" placeholder="İndirim" class="material-container__input urunInput" />
					<input id="tx" type="number" name="tax_<?php echo $n+1; ?>" value="<?php echo $dizi["vergi"]; ?>"  min="0" placeholder="Vergi " class="material-container__input urunInput" />
					<span> <span id="tot" class="totalSpan total_<?php echo $n+1; ?>"><?php echo $dizi["tutar"]." ".$this->session->userdata('para_birim'); ?></span></span>
					<input id="tot_hidden" type="hidden" value="<?php echo $dizi["tutar"]; ?>" name="total_<?php echo $n+1; ?>"/>
					</div>

			</div>
			
			<?php $n=$n+1;	endforeach;  endif; ?>	

			
			
			<div class="material-container__row">


			</div>
		
			<div class="faturaSonuc">

				
				<div class="faturaSonuc__row">
					<span class="faturaSonuc__title">Ara Toplam </span>
					<span class="faturaSonuc__number ara_toplam"><?php echo $dizi_fat["tutar"]." ".$this->session->userdata('para_birim'); ?></span>
				</div>
				<div class="faturaSonuc__row">
					<span class="faturaSonuc__title">İndirim </span>
					<span class="faturaSonuc__number indirim"><?php echo $dizi_fat["indirim"]." ".$this->session->userdata('para_birim'); ?></span>
				</div>
				<div class="faturaSonuc__row">
					<span class="faturaSonuc__title">Vergi </span>
					<span class="faturaSonuc__number vergi"><?php echo $dizi_fat["vergi"]." ".$this->session->userdata('para_birim'); ?></span>
				</div>
				<div class="faturaSonuc__row">
					<span class="faturaSonuc__title">Toplam </span>
					<span class="faturaSonuc__number toplam"><?php echo $dizi_fat["toplam"]." ".$this->session->userdata('para_birim'); ?></span>
				</div>

				<input id="ara_toplam" type="hidden" value="<?php echo $dizi_fat["tutar"]; ?>" name="ara_toplam" />
				<input id="indirim" type="hidden" value="<?php echo $dizi_fat["indirim"]; ?>" name="indirim" />
				<input id="vergi" type="hidden"  value="<?php echo $dizi_fat["vergi"]; ?>" name="vergi" />
				<input id="toplam" type="hidden"  value="<?php echo $fat_toplam=$dizi_fat["toplam"]; ?>" name="toplam" >
				<input id="top_alan" type="hidden"  value="<?php echo count($data["fatura_item_getir_duzenle"]);  ?>" name="top_alan" />
				<input id="fat_id" type="hidden" value="<?php echo $fat_id=$dizi_fat["id"]; ?>" name="fat_id" />
			</div>

			<div class="faturaGonder">
		<!--		<input type="submit" value="Faturayı Güncelle" class="flex-right">-->
			</div>


<h2>
	<?php if($data['side_menu']=="Satış Fatura Ayarları"){ echo'TÜM TAHSİLATLAR'; $tur="Tahsilat"; } ?>
	<?php if($data['side_menu']=="Alış Fatura Ayarları"){ echo'TÜM ÖDEMELER'; $tur="Ödeme"; } ?>	
</h2>

	<?php	$total=0;    $n=0;    if( $data["fatura_odeme_getir"] ) :  foreach( $data["fatura_odeme_getir"] as $dizi_odeme ) : ?>

	<?php if($data['side_menu']=="Satış Fatura Ayarları"){ if($dizi_odeme["giris_cikis"]!=1){continue;} } ?>
	<?php if($data['side_menu']=="Alış Fatura Ayarları"){ if($dizi_odeme["giris_cikis"]!=0){continue;} } ?>	

<?php

if($dizi_odeme["islem_turu"]==3){

?>
<div style="float:justify;">
<?php echo $n=$n+1; ?> Tarih: <?php echo $dizi_odeme["tarih"]; ?>  Tutar: <?php echo $dizi_odeme["tutar"]." ".$this->session->userdata('para_birim'); $total=$total+$dizi_odeme["tutar"]; ?> Toplam <?php echo $tur; ?>: <?php echo $total." ".$this->session->userdata('para_birim'); 
}

if($dizi_odeme["islem_turu"]==4){  ?>


	<?php if($data['side_menu']=="Satış Fatura Ayarları"){  ?>

<div style="float:justify;">
<?php echo $n=$n+1; ?> Tarih: <?php echo $dizi_odeme["tarih"]; ?>  Tutar: <?php echo $dizi_odeme["tutar"]." ".$this->session->userdata('para_birim'); $total=$total+$dizi_odeme["tutar"]; ?> Toplam <?php echo $tur; ?>: <?php echo $total." ".$this->session->userdata('para_birim'); 

echo " <a href='".base_url()."yonetim/fatura_goruntule/".$dizi_odeme["relation_id"]."'>İade Faturasını Görüntüle</a>";

 ?>

	<?php	continue; } ?>
	<?php if($data['side_menu']=="Alış Fatura Ayarları"){   ?>

<div style="float:justify;">
<?php echo $n=$n+1; ?> Tarih: <?php echo $dizi_odeme["tarih"]; ?>  Tutar: <?php echo $dizi_odeme["tutar"]." ".$this->session->userdata('para_birim'); $total=$total+$dizi_odeme["tutar"]; ?> Toplam <?php echo $tur; ?>: <?php echo $total." ".$this->session->userdata('para_birim'); 

echo " <a href='".base_url()."yonetim/fatura_goruntule/".$dizi_odeme["relation_id"]."'>İade Faturasını Görüntüle</a>";
 ?>

	<?php	continue; } ?>	

<?php
}
if($dizi_odeme["islem_turu"]==5){ 

if($fat_id==$dizi_odeme["relation_id"]){ 


	?>




<div style="float:justify;">
<?php echo $n=$n+1; ?> Tarih: <?php echo $dizi_odeme["tarih"]; ?>  Tutar: <?php echo $dizi_odeme["tutar"]." ".$this->session->userdata('para_birim'); $total=$total+$dizi_odeme["tutar"]; ?> Toplam <?php echo $tur; ?>: <?php echo $total." ".$this->session->userdata('para_birim'); 


	echo " <a href='".base_url()."yonetim/cek_senet/read/".$dizi_odeme["cek_id"]."'>Çek Görüntüle</a>";


}

}

 ?>

<br><br>
</div>



		<?php	endforeach;  endif; ?>

	<?php if($iade_fat!=0){
		$total = $total + $data["iade_edilen_fatura_miktari"];
	} if($total>=$fat_toplam){   ?>
	<br><br>
	<input type="button" value="Kapalı Fatura" "/>

	<?php	 } 
else{

	if($data['side_menu']=="Satış Fatura Ayarları"){ ?>
		<br><br>
	<input type="button" value="Tahsilat Yap" onclick="window.location.href = '<?php echo base_url(); ?>yonetim/fatura_tahsilat/add/<?php echo $fat_id; ?>';"/>

	<input type="button" value="Çek ile tahsilat" onclick="window.location.href = '<?php echo base_url(); ?>yonetim/cek_tahsilat/add/<?php echo $fat_id; ?>';"/>


	<?php }
	 if($data['side_menu']=="Alış Fatura Ayarları"){ ?> 
	 		<br><br>
	<input type="button" value="Ödeme Yap" onclick="window.location.href = '<?php echo base_url(); ?>yonetim/fatura_odeme/add/<?php echo $fat_id; ?>';"/>

	<input type="button" value="Çek ile ödeme" onclick="window.location.href = '<?php echo base_url(); ?>yonetim/cek_odeme/add/<?php echo $fat_id; ?>';"/>



	 <?php } 

}



	?>
	</form><br><br>




<?php if($irs_durum==1){ ?>

<h2>
TÜM İRSALİYELER
</h2>
	Tarih - İrsaliye No - Açıklama<br><br>
	<?php 	$total=0;    $n=0;    if( $data["irsaliyeler"] ) :  foreach( $data["irsaliyeler"] as $dizi_irs ) : ?>





<div style="float:justify;">

 <?php echo $dizi_irs[$n]["tarih"]; ?> - <?php echo $dizi_irs[$n]["irsaliye_no"]; ?> - <?php echo $dizi_irs[$n]["aciklama"]; ?> - <a href="<?php echo base_url(); ?>yonetim/irsaliye_goruntule/<?php echo $dizi_irs[$n]["id"]; ?>"> Görüntüle </a>
		<br>
</div>




		<?php	endforeach;  endif; ?>


<br><br>




	<form action="<?php echo base_url(); ?>yonetim/irsaliye_getir" method="post" >
	<input type="submit" value="İrsaliye Ekle"'/>

<input id="musteri"  name="fat_turu" value="<?php echo $data["fat_turu"]; ?>" type="hidden" placeholder="Fatura Türü" class="material-container__input" />
<input id="musteri" name="mus" value="<?php echo $c_id; ?>" type="hidden" placeholder="Fatura Türü" class="material-container__input" />	
<input id="musteri" name="fat_id" value="<?php echo $fat_id; ?>" type="hidden" placeholder="Fatura Türü" class="material-container__input" />	
	</form>

<?php } ?>
		</div>




	

	<?php	endforeach;  endif; ?>







</body>







<?php  $this->load->view('footer_ozel.php'); ?>
<script 
src="<?php echo base_url('assets/grocery_crud/js/jquery_plugins/ui') ?>/jquery-ui-1.10.3.custom.min.js">
</script>

<script>

	$(document).ready(function() { 

		$('.datepicker').datepicker();

		var faturaHesapla = function() {

				var 
				itemsLength = $('.item').length,
				aratoplam	= Number(0),
				indirim		= Number(0),
				vergi		= Number(0),
				toplam		= Number(0);



				
				for(var n=1; n <= itemsLength; n++ ){


					var 
					prc			= Number($("input[name*='prc_"+n+"']").val()),
					qty			= Number($("input[name*='qty_"+n+"']").val()),
					tax			= Number($("input[name*='tax_"+n+"']").val()),
					dis			= Number($("input[name*='discount_"+n+"']").val());


					var 
					total			= prc * qty,
					aratoplam	= aratoplam + total;


					var 
					dis_amount	= total / 100,
					dis_amount	= dis_amount * dis;
					indirim = indirim + dis_amount;

					total = total - dis_amount;	

					var 
					tax_amount = total / 100,
					tax_amount = tax_amount * tax;
					vergi = vergi + tax_amount;

					total = total + tax_amount;
					toplam = toplam + total;

					

				}


		}
		


		$('body').on('keyup change', '.urunInput', faturaHesapla);

	}); 




	$('#add').click(function () {
		var 
		n		= $('.item').length + 1,
		temp	= $('.item:first').clone();

		$('input:first', temp).attr('placeholder', 'Ürün/Hizmet #' + n);


		/*$('#des', temp).attr('placeholder', 'Açıklama #' + n);
		$('#pr', temp).attr('placeholder', 'Fiyat #' + n);
		$('#qt', temp).attr('placeholder', 'Miktar #' + n);
		$('#tx', temp).attr('placeholder', 'Vergi & #' + n);
		$('#dis', temp).attr('placeholder', 'İndirim #' + n);
		$('#tot', temp).attr('placeholder', 'Toplam #' + n);*/

		$('#des', temp).attr({
			'placeholder': 'Açıklama #' + n,
			'name': 'des_' + n
		}).val('');

		$('#pr', temp).attr({
			'placeholder': 'Fiyat #' + n,
			'name': 'prc_' + n
		}).val('');

		$('#qt', temp).attr({
			'placeholder': 'Miktar #' + n,
			'name': 'qty_' + n
		}).val('');

		$('#tx', temp).attr({
			'placeholder': 'Vergi & #' + n,
			'name': 'tax_' + n
		}).val('');


		$('#dis', temp).attr({
			'placeholder': 'İndirim #' + n,
			'name': 'discount_' + n
		}).val('');


		$('#tot', temp).attr('class', 'totalSpan total_' + n).text('0.00');

		$('#tot_hidden', temp).attr('name', 'total_' + n).val(0.00);

		$('#item', temp).attr('name', 'item_' + n).val('');

		/*$('#des', temp).attr('name', 'des_' + n).val('');
		$('#pr', temp).attr('name', 'prc_' + n).val('');
		$('#qt', temp).attr('name', 'qty_' + n).val('');
		$('#tx', temp).attr('name', 'tax_' + n).val('');
		$('#dis', temp).attr('name', 'discount_' + n).val('');
		$('#tot', temp).attr('name', 'total_' + n).val('');*/




		$('.item:last').after(temp);
					$("#top_alan").text(n);	

	});
/*
	function hesapla (){
		items();
		totals();
	}

	function items (){

		var uzunluk = $('.item').length;
		//alert(uzunluk);
	
	
	for(var n=1; n<=uzunluk; n++ ){

		var prc = Number($("input[name*='prc_"+n+"']").val());
		var qty = Number($("input[name*='qty_"+n+"']").val());
		var tax = Number($("input[name*='tax_"+n+"']").val());	
		var dis = Number($("input[name*='discount_"+n+"']").val());	



		var total = prc * qty ;

		var dis_amount = total / 100;
		dis_amount = dis_amount * dis;

		total = total - dis_amount;	

		var tax_amount = total / 100;
		tax_amount = tax_amount * tax;


		total = total + tax_amount;

		$("input[name*='total_"+n+"']").val(total.toFixed(2));	


	}

}

function totals (){
	
	

	var 
	uzunluk		= $('.item').length;
	aratoplam	= Number(0),
	indirim		= Number(0),
	vergi			= Number(0),
	toplam		= Number(0);
	
	for(var n=1; n<=uzunluk; n++ ){

		var prc = Number($("input[name*='prc_"+n+"']").val());
		var qty = Number($("input[name*='qty_"+n+"']").val());
		var tax = Number($("input[name*='tax_"+n+"']").val());	
		var dis = Number($("input[name*='discount_"+n+"']").val());	


		var total = prc * qty ;		
		aratoplam = aratoplam + total;


		var dis_amount = total / 100;
		dis_amount = dis_amount * dis;
		indirim = indirim + dis_amount;

		total = total - dis_amount;		

		var tax_amount = total / 100;
		tax_amount = tax_amount * tax;	
		vergi = vergi + tax_amount;

		total = total + tax_amount;	

		toplam = toplam + total;



	}
	
	// alert(aratoplam);
	//sayi.toFixed(2);
	
	$("input[name*='indirim']").val(indirim.toFixed(2));
	$("input[name*='vergi']").val(vergi.toFixed(2));
	$("input[name*='toplam']").val(toplam.toFixed(2));
	$("input[name*='ara_toplam']").val(aratoplam.toFixed(2));
}

*/

$('#del').click(function () {
	var n = $('.item').length;
	if(n!=1){$('.item:last').remove();
		$("#top_alan").text(n);	
}

});



</script>