<?php  $this->load->view('header_ozel.php'); ?>	
<link rel="stylesheet" href="<?php echo base_url('assets/grocery_crud/css/ui/simple') ?>/jquery-ui-1.10.1.custom.min.css">



<body>


		<div class="material-container">

			<h2 class="material-container__heading">
			
	<?php echo $stok_id." - ".$stok_adi."<br><br>	</h2>";


	echo "Tarihi - Alış Satış - İşlem Türü -  Miktar - Son <br> <br>";

	$n=0;    if( $stokhareket ) :  foreach( $stokhareket as $dizi ) :
			 if ($dizi["fatura_turu"]=="Gider"){ continue;	}

			 if ($dizi["islem_turu"]=="fatura"){ 	
			
			 if($dizi["irsaliye_durum"]==1){ 
		//	echo $stok_baslangic.'<br>'; 	
			 	$n=$n+1; continue;
			  }

  			 }


	    if ($dizi["fatura_turu"]=="Satış"){ $stok_baslangic=$stok_baslangic-$dizi["adet"];	}
		if ($dizi["fatura_turu"]=="Alış"){ $stok_baslangic=$stok_baslangic+$dizi["adet"];     }
		// echo $stok_baslangic.'<br>'; 	

if($dizi["islem_turu"]=="irsaliye"){ echo"<a href='".base_url()."yonetim/irsaliye_goruntule/".$dizi["fatura_id"]."'>"; }
if($dizi["islem_turu"]=="fatura"){}	


echo $dizi["fatura_tarihi"]." ** ".$dizi["fatura_turu"]." ** ".$dizi["islem_turu"]." ** ".$dizi["adet"]." ** ".$stok_baslangic."</a><br><br>";


$n=$n+1;	endforeach;  endif;


	 ?>
		
			
		
			<h2 class="material-container__heading">
			
	<?php echo "Güncel Stok Miktarı: ".$stok_baslangic."<br><br>	</h2>"; ?>
		
			</div>


		</div>




</body>







<?php  $this->load->view('footer_ozel.php'); ?>
<script 
src="<?php echo base_url('assets/grocery_crud/js/jquery_plugins/ui') ?>/jquery-ui-1.10.3.custom.min.js">
</script>

<script>

	$(document).ready(function() { 

		$('.datepicker').datepicker();

			$('body').on('keyup change', '.urunInput', function() {
				var 
				itemsLength = $('.item').length,
				aratoplam	= Number(0),
				indirim		= Number(0),
				vergi			= Number(0),
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

					$(".total_" + n).text(total.toFixed(2));
					$("input[name*='total_"+n+"']").val(total.toFixed(2));


					$(".indirim").text(indirim.toFixed(2));
					$(".vergi").text(vergi.toFixed(2));
					$(".toplam").text(toplam.toFixed(2));
					$(".ara_toplam").text(aratoplam.toFixed(2));

					$("#indirim").val(indirim.toFixed(2));
					$("#vergi").val(vergi.toFixed(2));
					$("#toplam").val(toplam.toFixed(2));
					$("#ara_toplam").val(aratoplam.toFixed(2));
					
					
					$("#top_alan").val(itemsLength);					

				}




		});

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