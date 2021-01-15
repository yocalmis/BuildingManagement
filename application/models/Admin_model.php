<?php
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_model extends CI_Model
{
	 function __construct()
     {
         parent::__construct();
         $this->load->database();
     }
	 
	 //Admin Varm� Yokmu Kontrol Et , Varsa Login'e Yoksa Kay�t sayfas�na y�nlendir
	 
	 
     
      function admin_query()
     {
   
        $sql = "SELECT * FROM uyeler";
        $query = $this->db->query($sql);
        
        if( $query->num_rows() > 0 )
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }

   
   
   
     }

    function admin_register_before($username,$email)
    {

        $sql = "SELECT * FROM uyeler Where username='$username' or email='$email'";
        $query = $this->db->query($sql);

        if( $query->num_rows() > 0 )
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }




    }

		 
		 
		   function admin_info()
    {
        $sql = "SELECT * FROM ayar";
        $query = $this->db->query($sql);
        
        if( $query->num_rows() > 0 )
        {
            return $query->result_array();
        }
        else
        {
            return FALSE;
        }
    }
		 
		 
		 
		 	 //Admin kaydet
		 
		 
         
              function admin_register($data)
     {
    $name=$this->db->escape_str($data[0]);
	$email=$this->db->escape_str($data[1]);
	$username=$this->db->escape_str($data[2]);
	$pass=$this->db->escape_str($data[3]);
	$bina_adi=$this->db->escape_str($data[4]);

	
 	$bugun=date("Y-m-d");
	$ondort=date("d.m.Y",strtotime('+14 days'));
	$ondort=explode(".",$ondort);
	$ondort=$ondort[2]."-".$ondort[1]."-".$ondort[0];   

	
	$insert=array(
	'name'=>$name,
	'username'=>$username,
	'pass'=>$pass,
	'email'=>$email,
	'status'=>0,
	'bas_tar'=>$bugun,
	'bit_tar'=>$ondort,
	'uye_turu'=>1,	
	
	);
	
	$into=$this->db->insert('uyeler',$insert);
	if($into){
		
	$insertId = $this->db->insert_id();		
	$insert2=array(
	'kullanici_id'=>$insertId 
	
	);	
		   $this->db->where('id',$insertId);		
	$into2=$this->db->update('uyeler',$insert2);	
	
	$insert3=array(
	'adi'=>$bina_adi,
	'kullanici_id'=>$insertId 	
	
	);	
	
	$binakayit=$this->db->insert('bina',$insert3);	
	$bina_insertId = $this->db->insert_id();		
	
	
	
	if($into2){return $pass;}else{return 0;}		
		
	}else{return 0;}	
	
	
	




     }
     
	  function kontrol($email)
     {
	
		$query =$this->db->query("select * from uyeler Where email='$email'");
        if( $query->num_rows() > 0 )
        {
            return 1;
        }
        else
        {
		   return 0;   
        }
	
	 }
	 
	 
	  	 	 function pass_getir($email)
     {
	
		$query =$this->db->query("select * from uyeler Where email='$email'");
        if( $query->num_rows() > 0 )
        {
            
					foreach ($query->result_array() as $row)
										{
										return $row['pass'];	
							
										}
			
        }
        else
        {
            return FALSE;
        }
	
	 } 	 
	 
	 
	 
	  	 function sifre_guncelle($sf,$pass)
     {
	
	
	
	$insert=array(
	'pass'=>$sf
	
	);
		  $this->db->where('pass',$pass);	
	$into=$this->db->update('uyeler',$insert);
	if($into){return 1;}else{return 0;}
	
	 }  
	 
	 
	 
	 //Admin login kontrol
	 
     
     function admin_return($data)
     {
 

    $username=$this->db->escape_str($data[0]);
	$pass=$this->db->escape_str($data[1]);
	$bugun=date("Y-m-d");
	
		$query =$this->db->query("select * from uyeler Where username='$username' and pass='$pass' and status=1");
		if ($query->num_rows() > 0)
		{
		
			$query =$this->db->query("select * from uyeler Where username='$username' and pass='$pass' and status=1 and bas_tar<='".$bugun."' and bit_tar >='".$bugun."' ");
 			if ($query->num_rows() > 0)
			{ 
		//Login
		return 2;
			}
			else{
				//Ödeme
				return 1;
			}
		
		
		} 
	
		else{
		return 0;
		}
	

   
     }

     function kullanici_id_tarih_kontrol($kul)
     {
 
	$bugun=date("Y-m-d");

	$query =$this->db->query("select * from uyeler Where kullanici_id=".$kul." and status=1 and bas_tar<='".$bugun."' and bit_tar >='".$bugun."' ");
    if ($query->num_rows() > 0)
    {return 1;}    else{return 0;}
    

   
     }
     
     function admin_bilgi($data)
     {
    $username=$this->db->escape_str($data[0]);
	$pass=$this->db->escape_str($data[1]);

	$query =$this->db->query("select * from uyeler Where username='$username' and pass='$pass' ");
	if( $query->num_rows() > 0 )
        {
            return $query->result_array();
        }
        else
        {
            return FALSE;
        }
    

   
     }
	 
	     function para_birimi($kullanici_id)
     {

	$query =$this->db->query("select * from bina Where kullanici_id=".$kullanici_id."");
	if( $query->num_rows() > 0 )
        {
            return $query->result_array();
        }
        else
        {
            return FALSE;
        }
    

   
     } 
	 
	 
	 	  function mail_cikis($ep1,$ep2)
     {

	 $ep=$ep1."@".$ep2;

	$query =$this->db->query("update cari set eposta_durum=0 Where eposta='$ep'");
    if ($query)
    {return 1;}    
     else{return 0;}
    

   
     }  
	 
	 
	 
	 
	 
    function mail_getir($kul_id)
    {

        $sql = "SELECT eposta FROM cari Where kullanici_id=".$kul_id." and eposta_durum=1";
        $query = $this->db->query($sql);

        if( $query->num_rows() > 0 )
        {
            return $query->result_array();
        }
        else
        {
            return FALSE;
        }




    }
	 

	 
	 	 function uye_onay($pass)
     {
	
	
	
	$insert=array(
	'status'=>1
	
	);
		  $this->db->where('pass',$pass);	
	$into=$this->db->update('uyeler',$insert);
	if($into){
		
		return 1;
		
		
		}else{return 0;}
	
	 } 
	 
	  	 function mails($pass)
     {
		 
			$query =$this->db->query("select * from uyeler Where pass='$pass'");
		foreach ($query->result_array() as $row)
		{
        return $row['email'];
		}	
	
	
	 } 
	 
	 
	 
	 
	 
	   	 function uye_turu_getir($online)
     { 		 
			$query =$this->db->query("select * from uyeler Where username='$online'");
		foreach ($query->result_array() as $row)
		{
        return $row['uye_turu'];
		}	
	
	
	 } 
	 
	 
	
	
	 
	 
	 	 
	   	 function uye_id_getir($online) 
     { 		 
			$query =$this->db->query("select * from uyeler Where username='$online'");
		foreach ($query->result_array() as $row)
		{
        return $row['id'];
		}	
	
	
	 } 
	 
	 	   	 function yetki_kontrol_bina($kul_id,$id) 
     { 		 
			$query =$this->db->query("select * from bina Where id=".$id." and kullanici_id=".$kul_id."");
        if( $query->num_rows() > 0 )
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }

	
	
	 } 
	 
	 
	 	   	 function yetki_kontrol_blok($kul_id,$id) 
     { 		 
			$query =$this->db->query("select * from blok Where id=".$id." and kullanici_id=".$kul_id."");
        if( $query->num_rows() > 0 )
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }

	
	
	 } 
	 
	  	   	 function blok_bilgi_getir($kul_id,$id) 
     { 		 
			$query =$this->db->query("select * from blok Where id=".$id." and kullanici_id=".$kul_id."");
         if( $query->num_rows() > 0 )
        {
            return $query->result_array();
        }
        else
        {
            return FALSE;
        }

	
	
	 } 
	 
	 
	 
	 
	   	 function daire_say($kul_id,$id) 
     { 		 
			$query =$this->db->query("select * from daire Where id=".$id." and kullanici_id=".$kul_id."");
            return $query->num_rows();
	
	
	 }  
	 
	 
	 
	  	   	 function yetki_kontrol_daire($kul_id,$id) 
     { 		 
			$query =$this->db->query("select * from daire Where id=".$id." and kullanici_id=".$kul_id."");
        if( $query->num_rows() > 0 )
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }

	
	
	 } 


	 	  	   	 function yetki_kontrol_cek_senet($kul_id,$id) 
     { 		 
			$query =$this->db->query("select * from cek_senet Where id=".$id." and kullanici_id=".$kul_id);
        if( $query->num_rows() > 0 )
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }

	
	
	 } 
	 
	  
	  	   	 function yetki_kontrol_cari($kul_id,$id) 
     { 		 
			$query =$this->db->query("select * from cari Where id=".$id." and kullanici_id=".$kul_id."");
        if( $query->num_rows() > 0 )
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }

	
	
	 } 
	 
	 
	 
	   	 function yetki_kontrol_zimmet($kul_id,$id) 
     { 		 
			$query =$this->db->query("select * from zimmet Where id=".$id." and kullanici_id=".$kul_id."");
        if( $query->num_rows() > 0 )
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }

	
	
	 } 
	 
	 
	 	 
	   	 function yetki_kontrol_izin($kul_id,$id) 
     { 		 
			$query =$this->db->query("select * from izin Where id=".$id." and kullanici_id=".$kul_id."");
        if( $query->num_rows() > 0 )
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }

	
	
	 } 
	 
	    	 function yetki_kontrol_hiz($kul_id,$id) 
     { 		 
			$query =$this->db->query("select * from hizmet_urun Where id=".$id." and kullanici_id=".$kul_id."");
        if( $query->num_rows() > 0 )
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }

	
	
	 } 
	 
	 
	    	 function yetki_kontrol_gider($kul_id,$id) 
     { 		 
			$query =$this->db->query("select * from gider_kategori Where id=".$id." and kullanici_id=".$kul_id."");
        if( $query->num_rows() > 0 )
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }

	
	
	 }  
	 
	 
	  	 function yetki_kontrol_kasa($kul_id,$id) 
     { 		 
			$query =$this->db->query("select * from kasa Where id=".$id." and kullanici_id=".$kul_id."");
        if( $query->num_rows() > 0 )
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }

	
	
	 } 
	 
	 	 function yetki_kontrol_komite($kul_id,$id) 
     { 		 
			$query =$this->db->query("select * from komite Where id=".$id." and kullanici_id=".$kul_id."");
        if( $query->num_rows() > 0 )
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }

	
	
	 } 
	 
	 
	 
	 	   	 function blok_ad($id) 
     { 		 
			$query =$this->db->query("select * from blok Where id='".$id."'");
		foreach ($query->result_array() as $row)
		{
        return $row['adi'];
		}	
	
	
	 } 
	 	 	 
	   	 function cari_ad($id) 
     { 		 
			$query =$this->db->query("select * from cari Where id='".$id."'");
		foreach ($query->result_array() as $row)
		{
        return $row['adi_soyadi'];
		}	
	
	
	 } 

	 
	 
	 	   	 function demirbas_ad($id) 
     { 		 
			$query =$this->db->query("select * from hizmet_urun Where id='".$id."'");
		foreach ($query->result_array() as $row)
		{
        return $row['adi'];
		}	
	
	
	 } 
	 
	 
	 
	  	 	 
	   	 function kasa_ad($id) 
     { 		 
			$query =$this->db->query("select * from kasa Where id='".$id."'");
		foreach ($query->result_array() as $row)
		{
        return $row['adi'];
		}	
	
	
	 } 
	 
	 
	 	 	 function yetki_kontrol_uye($kul_id,$id) 
     { 		 
			$query =$this->db->query("select * from uyeler Where id=".$id." and kullanici_id=".$kul_id."");
        if( $query->num_rows() > 0 )
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }

	
	
	 } 
	 
	 
	 	   	 function yetki_kontrol_dosya($kul_id,$id) 
     { 		 
			$query =$this->db->query("select * from dosyalar Where id=".$id." and kullanici_id=".$kul_id."");
        if( $query->num_rows() > 0 )
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }

	
	
	 } 
	 
	 
	 
	 
	  
	 	   	 function yetki_kontrol_kategori($kul_id,$id) 
     { 		 
			$query =$this->db->query("select * from kategori Where id=".$id." and kullanici_id=".$kul_id."");
        if( $query->num_rows() > 0 )
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }

	
	
	 } 
	 
	 	  
	 	   	 function 	 yetki_kontrol_gelir_gider($kul_id,$id) 
     { 		 
			$query =$this->db->query("select * from islem Where id=".$id." and kullanici_id=".$kul_id."");
        if( $query->num_rows() > 0 )
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }

	
	
	 } 
	 
	 	 	   	 function 	 	 yetki_kontrol_virman($kul_id,$id) 
     { 		 
			$query =$this->db->query("select * from virman Where id=".$id." and kullanici_id=".$kul_id."");
        if( $query->num_rows() > 0 )
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }

	
	
	 } 
	 
	 
	 	 function 	 	 yetki_kontrol_borc($kul_id,$id) 
     { 		 
			$query =$this->db->query("select * from borc_alacak Where id=".$id." and kullanici_id=".$kul_id."");
        if( $query->num_rows() > 0 )
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }

	
	
	 } 
	 
	 
	 

	 
	 
    function virman_getir($kul_id,$id)
    {

        $sql = "SELECT * FROM virman Where kullanici_id=".$kul_id." and id=".$id."";
        $query = $this->db->query($sql);

        if( $query->num_rows() > 0 )
        {
            return $query->result_array();
        }
        else
        {
            return FALSE;
        }




    }
	
	
	    function islem_getir($kul_id,$id)
    {

        $sql = "SELECT * FROM islem Where kullanici_id=".$kul_id." and relation_id=".$id."";
        $query = $this->db->query($sql);

        if( $query->num_rows() > 0 )
        {
            return $query->result_array();
        }
        else
        {
            return FALSE;
        }




    }
	
	
	 
	 
	    function islem_kayit($data)
     {


	$insert=array(
	'islem_turu'=>1,
	'relation_type'=>"Banka",
	'relation_id'=>$data[0],
	'giris_cikis'=>0,
	'tutar'=>$data[3],
	'tarih'=>$data[4],
	'aciklama'=>$data[5],
	'kasa_id'=>$data[1],	
	'kullanici_id'=>$data[6],	
	'cari_id'=>0,	
	'kategori'=>"",	
	);
	
	$into=$this->db->insert('islem',$insert);
	
	
	
	
	
	
	if($into){
		
	$insert2=array(
	'islem_turu'=>1,
	'relation_type'=>"Banka",
	'relation_id'=>$data[0],
	'giris_cikis'=>1,
	'tutar'=>$data[3],
	'tarih'=>$data[4],
	'aciklama'=>$data[5],
	'kasa_id'=>$data[2],	
	'kullanici_id'=>$data[6],	
	'cari_id'=>0,	
	'kategori'=>"",	
	);
	
	$into2=$this->db->insert('islem',$insert2);

	if($into2){	return TRUE;}		
		return FALSE;
	}
	return FALSE;
	
		 
	




     }
     
	     function boal_getir($kul_id,$id)
    {

        $sql = "SELECT * FROM borc_alacak Where kullanici_id=".$kul_id." and id=".$id."";
        $query = $this->db->query($sql);

        if( $query->num_rows() > 0 )
        {
            return $query->result_array();
        }
        else
        {
            return FALSE;
        }




    }
	 
	 
	 
	 
	 
	    function islem_kayit_boal($data)
     {
//1 cari borçlandır
//2 cari alacaklandır

	$insert=array(
	'islem_turu'=>2,
	'relation_type'=>"Borç_Alacak",
	'relation_id'=>$data[0],
	'giris_cikis'=>$data[1],
	'tutar'=>$data[2],
	'tarih'=>$data[5],
	'aciklama'=>$data[7],
	'kasa_id'=>0,	
	'kullanici_id'=>$data[4],	
	'cari_id'=>$data[3],	
	'kategori'=>"",	
	);
	
	$into=$this->db->insert('islem',$insert);
	
	
	
	
	
	
	if($into){
		
	
		return TRUE;
	}
	return FALSE;
	
		 
	




     }
	 
	 
	 
	 
	      function toplu_boalkayit($data)
     {
//1 cari borçlandır
//2 cari alacaklandır


	$insert=array(
	'fatura_turu'=>$data[0],
	'toplam'=>$data[1],
	'cari_id'=>$data[2],
	'kullanici_id'=>$data[3],
	'tarih'=>$data[4],
	'aciklama'=>$data[6],
	'vade_tarihi'=>$data[5]
	);
	
	$into=$this->db->insert('borc_alacak',$insert);

	
	if($into){
		
	
		return TRUE;
	}
	return FALSE;



     }
	
	
	
	
	   	 function sahip_bos_varmi($kul)
     { 		 
			$query =$this->db->query("select * from daire Where kullanici_id=".$kul." and sahip_id=0");
	        return $query->num_rows();
	
	 } 
	 
	 
  	 function 	 	 cari_baslangic($id,$kul_id) 
     { 		 

		$query =$this->db->query("select * from cari Where id=".$id." and kullanici_id=".$kul_id);
		foreach ($query->result_array() as $row)
		{
        return $row['bas_borc_alacak'];
		}	
	
	
	 }


	  	 function 	 	 cari_baslangic_durum($id,$kul_id) 
     { 		 

		$query =$this->db->query("select * from cari Where id=".$id." and kullanici_id=".$kul_id);
		foreach ($query->result_array() as $row)
		{
        return $row['bas_boal_durum'];
		}	
	
	
	 }
	 
	  	 function 	 	 cari_toplam_getir($id,$kul_id) 
     { 		 
			$query =$this->db->query("select * from islem Where cari_id=".$id." and kullanici_id=".$kul_id);
        if( $query->num_rows() > 0 )
        {
            return $query->result_array();
        }
        else
        {
            return FALSE;
        }
	
	
	 } 
	 
	   	 function 	 	 vade_tarihi_getir($id,$kul_id) 
     { 		 

		$query =$this->db->query("select * from borc_alacak Where id=".$id." and kullanici_id=".$kul_id);
		foreach ($query->result_array() as $row)
		{
        return $row['vade_tarihi'];
		}	
	
	
	 }


	 	   	 function 	 	 vade_tarihi_getir_fatura($id,$kul_id) 
     { 		 

		$query =$this->db->query("select * from fatura Where id=".$id." and kullanici_id=".$kul_id);
		foreach ($query->result_array() as $row)
		{
        return $row['vade_tarihi'];
		}	
	
	
	 }
	 
	 
	 
	 	 	 	 function 	 	 yetki_kontrol_cari_detay($kul_id,$id) 
     { 		 
			$query =$this->db->query("select * from cari Where id=".$id." and kullanici_id=".$kul_id."");
        if( $query->num_rows() > 0 )
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }

	
	
	 } 
	 
	 
	 
	 	 	 function 	 	 yetki_kontrol_islem($kul_id,$id) 
     { 		 
			$query =$this->db->query("select * from islem Where id=".$id." and kullanici_id=".$kul_id."");
        if( $query->num_rows() > 0 )
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }

	
	
	 } 
	 
	 	   	 function 	 	 cari_adi($id,$kul_id) 
     { 		 

		$query =$this->db->query("select * from cari Where id=".$id." and kullanici_id=".$kul_id);
		foreach ($query->result_array() as $row)
		{
        return $row['adi_soyadi'];
		}	
	
	
	 } 
	 
		   	 function 	 	 kasa_adi($id,$kul_id) 
     { 		 

		$query =$this->db->query("select * from kasa Where id=".$id." and kullanici_id=".$kul_id);
		foreach ($query->result_array() as $row)
		{
        return $row['adi'];
		}	
	
	
	 } 
	 


	   	 function 	 	 iade_edilen_fatura_miktari($if,$kul_id) 
     { 		 

		$query =$this->db->query("select * from fatura Where id=".$if." and kullanici_id=".$kul_id);
		foreach ($query->result_array() as $row)
		{
        return $row['toplam'];
		}	
	
	
	 }


	 
	   	 function 	 	 kasa_baslangic($id,$kul_id) 
     { 		 

		$query =$this->db->query("select * from kasa Where id=".$id." and kullanici_id=".$kul_id);
		foreach ($query->result_array() as $row)
		{
        return $row['bas_kasa'];
		}	
	
	
	 }
	 
	  	 function 	 	 kasa_toplam_getir($id,$kul_id) 
     { 		 
			$query =$this->db->query("select * from islem Where kasa_id=".$id." and kullanici_id=".$kul_id);
        if( $query->num_rows() > 0 )
        {
            return $query->result_array();
        }
        else
        {
            return FALSE;
        }
	
	
	 }
	 
	 
	 
	 	 	 	 	 function 	 	 yetki_kontrol_kasa_detay($kul_id,$id) 
     { 		 
			$query =$this->db->query("select * from kasa Where id=".$id." and kullanici_id=".$kul_id."");
        if( $query->num_rows() > 0 )
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }

	
	
	 } 
	 
	 
	 
	 
	 
	     function list_getir($id)
    {

        $sql = "SELECT * FROM task Where kim=".$id;
        $query = $this->db->query($sql);

        if( $query->num_rows() > 0 )
        {
            return $query->result_array();
        }
        else
        {
            return FALSE;
        }




    }
	 
	 
	 
	      function sss_getir()
    {

        $sql = "SELECT * FROM sss";
        $query = $this->db->query($sql);

        if( $query->num_rows() > 0 )
        {
            return $query->result_array();
        }
        else
        {
            return FALSE;
        }




    }
	 
	 
	 
	 
	 
	 
	    	 function yetki_kontrol_teklif($kul_id,$id) 
     { 		 
			$query =$this->db->query("select * from teklif Where id=".$id." and kullanici_id=".$kul_id."");
        if( $query->num_rows() > 0 )
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }

	
	
	 } 
	 
	 
	 
	 
	 
	    	 function yetki_kontrol_not($kul_id,$id) 
     { 		 
			$query =$this->db->query("select * from notlar Where id=".$id." and kullanici_id=".$kul_id."");
        if( $query->num_rows() > 0 )
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }

	
	
	 } 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
		

	 
	 
	 
	 			function toplam_tahsilat( $buyil,$bugun_bit ) {
	
			$this->db->select_sum('tutar');
			$this->db->from('islem');		
			$this->db->where('giris_cikis',1);	
			$this->db->where('islem_turu', 3);	
			$this->db->where('kullanici_id',$this->session->userdata('kullanici_id'));				
			$query = $this->db->get();
			if(!$query->row()->tutar){return 0;}	
			return $query->row()->tutar;		
	
			}	

			function toplam_odeme( $buyil,$bugun_bit ) {
	
			$this->db->select_sum('tutar');
			$this->db->from('islem');		
			$this->db->where('giris_cikis',0);	
			$this->db->where('islem_turu', 3);		
			$this->db->where('kullanici_id',$this->session->userdata('kullanici_id'));				
			$query = $this->db->get();
			if(!$query->row()->tutar){return 0;}	
			return $query->row()->tutar;	
	
			}
		
		
			function toplam_gelir( $buyil,$bugun_bit ) {
	
			$this->db->select_sum('tutar');
			$this->db->from('islem');			
			$this->db->where('giris_cikis',1);	
			$this->db->where('islem_turu', 0);		
			$this->db->where('kullanici_id',$this->session->userdata('kullanici_id'));				
			$query = $this->db->get();
			if(!$query->row()->tutar){return 0;}	
			return $query->row()->tutar;
	
			}	
		
		
		
			function toplam_gider( $buyil,$bugun_bit ) {
	
			$this->db->select_sum('tutar');
			$this->db->from('islem');		
			$this->db->where('giris_cikis',0);	
			$this->db->where('islem_turu', 0);		
			$this->db->where('kullanici_id',$this->session->userdata('kullanici_id'));				
			$query = $this->db->get();
			if(!$query->row()->tutar){return 0;}	
			return $query->row()->tutar;	
	
			}	
		
		
			function toplam_alis( $buyil,$bugun_bit ) {
	
			$this->db->select_sum('tutar');
			$this->db->from('islem');		
			$this->db->where('giris_cikis',0);	
			//$this->db->where('islem_turu', 2);	
			$this->db->group_start();
			$this->db->where("islem_turu = 2");
			$this->db->group_end();		
			$this->db->where('kullanici_id',$this->session->userdata('kullanici_id'));				
			$query = $this->db->get();
			if(!$query->row()->tutar){$borclanilan=0;}	
			$borclanilan=$query->row()->tutar;


			$this->db->select_sum('tutar');
			$this->db->from('islem');		
			$this->db->where('giris_cikis',1);	
			//$this->db->where('islem_turu', 2);	
			$this->db->group_start();
			$this->db->where("islem_turu = 4");
			$this->db->group_end();		
			$this->db->where('kullanici_id',$this->session->userdata('kullanici_id'));				
			$query = $this->db->get();
			if(!$query->row()->tutar){$alis=0;}	
			$alis=$query->row()->tutar;

			return $borclanilan+$alis;




	
			}	
		
			function toplam_satis( $buyil,$bugun_bit ) {



		$this->db->select_sum('tutar');
			$this->db->from('islem');		
			$this->db->where('giris_cikis',1);	
			//$this->db->where('islem_turu', 2);	
			$this->db->group_start();
			$this->db->where("islem_turu = 2");
			$this->db->group_end();		
			$this->db->where('kullanici_id',$this->session->userdata('kullanici_id'));				
			$query = $this->db->get();
			if(!$query->row()->tutar){$borclanilan=0;}	
			$borclanilan=$query->row()->tutar;


			$this->db->select_sum('tutar');
			$this->db->from('islem');		
			$this->db->where('giris_cikis',0);	
			//$this->db->where('islem_turu', 2);	
			$this->db->group_start();
			$this->db->where("islem_turu = 4");
			$this->db->group_end();		
			$this->db->where('kullanici_id',$this->session->userdata('kullanici_id'));				
			$query = $this->db->get();
			if(!$query->row()->tutar){$alis=0;}	
			$alis=$query->row()->tutar;

			return $borclanilan+$alis;




	
			}	
	 
	 
	 
	 
	 /*
	 
				function genel_durum_giris( $buyil,$bugun_bit ) {
	
			$this->db->select_sum('tutar');
			$this->db->from('islem');			
			$this->db->where('giris_cikis',1);			
			$this->db->where('kullanici_id',$this->session->userdata('kullanici_id'));				
			$query = $this->db->get();
			if(!$query->row()->tutar){return 0;}	
			return $query->row()->tutar;
	



			}	 
	 
	 
					function genel_durum_cikis( $buyil,$bugun_bit ) {
	
			$this->db->select_sum('tutar');
			$this->db->from('islem');			
			$this->db->where('giris_cikis',0);			
			$this->db->where('kullanici_id',$this->session->userdata('kullanici_id'));				
			$query = $this->db->get();
			if(!$query->row()->tutar){return 0;}	
			return $query->row()->tutar;
	
			}	 


					function toplam_durum( $buyil,$bugun_bit ) {
	
			return $this->genel_durum_cari($buyil,$bugun_bit)+$this->genel_durum_giris($buyil,$bugun_bit)-$this->genel_durum_cikis($buyil,$bugun_bit);
			//+$this->genel_durum_giris($buyil,$bugun_bit)-$this->genel_durum_cikis($buyil,$bugun_bit);
			
	
			}




	 */






	 
	 					function genel_durum_cari( $buyil,$bugun_bit ) {

		$toplam=0;
				$query =$this->db->query("select * from cari Where kullanici_id=".$this->session->userdata('kullanici_id'));
		foreach ($query->result_array() as $row)
		{
        $bas_boal_durum=$row['bas_boal_durum'];
        $bas_borc_alacak=$row['bas_borc_alacak'];  
    	if($bas_boal_durum==0){}   
		else{$bas_borc_alacak = 0-$bas_borc_alacak;}

        $toplam=$toplam+$bas_borc_alacak;

		}


		return $toplam;



	
			}	


			
							function toplam_durum( $buyil,$bugun_bit ) {
	

$top=0;
$top=$top+$this->genel_durum_cari($buyil,$bugun_bit);

		$query =$this->db->query("select * from islem where kullanici_id=".$this->session->userdata('kullanici_id'));
		foreach ($query->result_array() as $row)
		{

if(($row['islem_turu']==0) or ($row['islem_turu']==1) or ($row['islem_turu']==5))
{ continue;}

if($row['islem_turu']==2){
if($row['giris_cikis']==0){$top = $top -$row['tutar']; }
if($row['giris_cikis']==1){$top = $top +$row['tutar']; }
}

if($row['islem_turu']==4){
if($row['giris_cikis']==0){$top = $top +$row['tutar']; }
if($row['giris_cikis']==1){$top = $top -$row['tutar']; }

}

if($row['islem_turu']==3){
if($row['giris_cikis']==0){$top = $top +$row['tutar']; }
if($row['giris_cikis']==1){$top = $top -$row['tutar']; }

}



		}	



        return $top;



	
	
			}
			
	 
	 
	 
	  
	 
	 
	 					function genel_durum_kasa( $buyil,$bugun_bit ) {
	
			$this->db->select_sum('bas_kasa');
			$this->db->from('kasa');					
			$this->db->where('kullanici_id',$this->session->userdata('kullanici_id'));				
			$query = $this->db->get();
			if(!$query->row()->bas_kasa){return 0;}	
			return $query->row()->bas_kasa;
	
			}	
			
							function toplam_durum_kasa( $buyil,$bugun_bit ) {
	
			//$this->genel_durum_kasa($buyil,$bugun_bit);;


$top=0;
$top=$top+$this->genel_durum_kasa($buyil,$bugun_bit);

		$query =$this->db->query("select * from islem where kullanici_id=".$this->session->userdata('kullanici_id'));
		foreach ($query->result_array() as $row)
		{

if(($row['islem_turu']==2) or ($row['islem_turu']==4) or ($row['islem_turu']==1) or ($row['islem_turu']==5))
{ continue;}

if($row['islem_turu']==0){
if($row['giris_cikis']==0){$top = $top -$row['tutar']; }
if($row['giris_cikis']==1){$top = $top +$row['tutar']; }
}

if($row['islem_turu']==3){
if($row['giris_cikis']==0){$top = $top -$row['tutar']; }
if($row['giris_cikis']==1){$top = $top +$row['tutar']; }

}



		}	



        return $top;





	
			}
			
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
				function tarih_durum_giris( $t1,$t2 ) {
	
			$this->db->select_sum('tutar');
			$this->db->from('islem');			
			$this->db->where('giris_cikis',1);	
			$this->db->where('tarih>=', $t1);
			$this->db->where('tarih<=', $t2);				
			$this->db->where('kullanici_id',$this->session->userdata('kullanici_id'));				
			$query = $this->db->get();
			if(!$query->row()->tutar){return 0;}	
			return $query->row()->tutar;
	
			}	 
	 
	 
					function tarih_durum_cikis($t1,$t2 ) {
	
			$this->db->select_sum('tutar');
			$this->db->from('islem');			
			$this->db->where('giris_cikis',0);	
			$this->db->where('tarih>=', $t1);
			$this->db->where('tarih<=', $t2);				
			$this->db->where('kullanici_id',$this->session->userdata('kullanici_id'));				
			$query = $this->db->get();
			if(!$query->row()->tutar){return 0;}	
			return $query->row()->tutar;
	
			}	 
	 
	 
	 					function tarih_durum_cari( $t1,$t2 ) {
	
			$this->db->select_sum('bas_borc_alacak');
			$this->db->from('cari');					
			$this->db->where('kullanici_id',$this->session->userdata('kullanici_id'));				
			$query = $this->db->get();
			if(!$query->row()->bas_borc_alacak){return 0;}	
			return $query->row()->bas_borc_alacak;
	
			}	
			
							function durum( $t1,$t2 ) {
	
			return $this->tarih_durum_giris($t1,$t2)-$this->tarih_durum_cikis($t1,$t2);
			//+$this->genel_durum_giris($buyil,$bugun_bit)-$this->genel_durum_cikis($buyil,$bugun_bit);
			
	
			}
			
	 
	 
	 
	 
	 
				function tarih_kasa_durum_giris( $t1,$t2 ) {
	
			$this->db->select_sum('tutar');
			$this->db->from('islem');			
			$this->db->where('giris_cikis',1);	
			$this->db->where('tarih>=', $t1);
			$this->db->where('tarih<=', $t2);	
			$this->db->where("(islem_turu = 0 OR islem_turu = 3)");		
			$this->db->where('kullanici_id',$this->session->userdata('kullanici_id'));				
			$query = $this->db->get();
			if(!$query->row()->tutar){return 0;}	
			return $query->row()->tutar;
	
			}	 
	 
	 
					function tarih_kasa_durum_cikis( $t1,$t2 ) {
	
			$this->db->select_sum('tutar');
			$this->db->from('islem');			
			$this->db->where('giris_cikis',0);	
			$this->db->where('tarih>=', $t1);
			$this->db->where('tarih<=', $t2);	
			$this->db->where("(islem_turu = 0 OR islem_turu = 3)");		
			$this->db->where('kullanici_id',$this->session->userdata('kullanici_id'));				
			$query = $this->db->get();
			if(!$query->row()->tutar){return 0;}	
			return $query->row()->tutar;
	
			}	 
	 
	 
	 					function tarih_genel_durum_kasa( $t1,$t2 ) {
	
			$this->db->select_sum('bas_kasa');
			$this->db->from('kasa');					
			$this->db->where('kullanici_id',$this->session->userdata('kullanici_id'));				
			$query = $this->db->get();
			if(!$query->row()->bas_kasa){return 0;}	
			return $query->row()->bas_kasa;
	
			}	
			
							function kasa( $t1,$t2 ) {
	
			return $this->tarih_kasa_durum_giris($t1,$t2)-$this->tarih_kasa_durum_cikis($t1,$t2);
			//+$this->genel_durum_giris($buyil,$bugun_bit)-$this->genel_durum_cikis($buyil,$bugun_bit);
			
	
			}
			
	 
	 
	 
	     function tum_urun_getir($kul_id)
    {

        $sql = "SELECT * FROM hizmet_urun Where kullanici_id=".$kul_id." and durum=1";
        $query = $this->db->query($sql);

        if( $query->num_rows() > 0 )
        {
            return $query->result_array();
        }
        else
        {
            return FALSE;
        }




    } 

    	     function tum_gider_urun_getir($kul_id)
    {

        $sql = "SELECT * FROM gider_kategori Where kullanici_id=".$kul_id." and durum=1";
        $query = $this->db->query($sql);

        if( $query->num_rows() > 0 )
        {
            return $query->result_array();
        }
        else
        {
            return FALSE;
        }




    } 
	 

     function kasa_getir($kul_id)
    {

        $sql = "SELECT * FROM kasa Where kullanici_id=".$kul_id;
        $query = $this->db->query($sql);

        if( $query->num_rows() > 0 )
        {
            return $query->result_array();
        }
        else
        {
            return FALSE;
        }




    } 

	 
	     function tum_cari_getir($kul_id)
    { 
        $sql = "SELECT * FROM cari Where kullanici_id=".$kul_id." and durum=1";
        $query = $this->db->query($sql);

        if( $query->num_rows() > 0 )
        {
            return $query->result_array();
        }
        else
        {
            return FALSE;
        }



    }
	 
	 
	 
	      function fat_kayit($fat_turu,$ara_toplam,$indirim,$vergi,$toplam,$mus,$seri,$no,$duz_ta,$va_ta,$ack,$irs_durum,$fat_turu,$kul_id)
    { 
   
     	if($fat_turu=="Gider"){ $gel_gid="1";}
	else{ $gel_gid="0"; }
 	 
	 	$insert=array(
	'fatura_turu'=>$fat_turu,
	'tutar'=>$ara_toplam,
	'vergi'=>$vergi,
	'indirim'=>$indirim,
	'toplam'=>$toplam,
	'kullanici_id'=>$kul_id,
	'cari_id'=>$mus,
	'tarih'=>$duz_ta,
	'vade_tarihi'=>$va_ta,
	'seri_no'=>$seri,
	'fatura_no'=>$no,
	'aciklama'=>$ack,
		'irsaliye_durum'=>$irs_durum,
		'gelir_gider_fat'=>$gel_gid,
	);	
	
	$this->db->insert('fatura',$insert);	
	return $this->db->insert_id();	  
   


    }



	      function iade_fat_kayit($fat_id,$fat_turu,$ara_toplam,$indirim,$vergi,$toplam,$mus,$seri,$no,$duz_ta,$va_ta,$ack,$irs_durum,$fat_turu,$kul_id)
    { 
   
     	if($fat_turu=="Gider"){ $gel_gid="1";}
	else{ $gel_gid="0"; }
 	 
	 	$insert=array(
	'fatura_turu'=>$fat_turu,
	'tutar'=>$ara_toplam,
	'vergi'=>$vergi,
	'indirim'=>$indirim,
	'toplam'=>$toplam,
	'kullanici_id'=>$kul_id,
	'cari_id'=>$mus,
	'tarih'=>$duz_ta,
	'vade_tarihi'=>$va_ta,
	'seri_no'=>$seri,
	'fatura_no'=>$no,
	'aciklama'=>$ack,
		'irsaliye_durum'=>$irs_durum,
		'gelir_gider_fat'=>$gel_gid,
		'iade_fat'=>$fat_id,		
	);	
	
	$this->db->insert('fatura',$insert);	
	return $this->db->insert_id();	  
   


    }



       function fat_guncelle($fat_id,$fat_turu,$ara_toplam,$indirim,$vergi,$toplam,$mus,$seri,$no,$duz_ta,$va_ta,$ack,$irs_durum,$kul_id)
    { 
   
  
 	 
	 	$insert=array(
	'fatura_turu'=>$fat_turu,
	'tutar'=>$ara_toplam,
	'vergi'=>$vergi,
	'indirim'=>$indirim,
	'toplam'=>$toplam,
	'kullanici_id'=>$kul_id,
	'cari_id'=>$mus,
	'tarih'=>$duz_ta,
	'vade_tarihi'=>$va_ta,
	'seri_no'=>$seri,
	'fatura_no'=>$no,
	'aciklama'=>$ack,
		'irsaliye_durum'=>$irs_durum,

	);	
	

	$this->db->where('id',$fat_id);
	$this->db->update('fatura',$insert);	
	//return $this->db->insert_id();	  


	$this->db->where('fatura_id',$fat_id);	
	$this->db->delete('fatura_item');
   
return TRUE;

    }
	 
	     function islem_kayit_fat($is_t,$rel_t,$fat_id,$gir_cik,$toplam,$duz_ta,$ack,$mus,$fat_turu,$kul_id)
    { 
   
   	if($fat_turu=="Gider"){ $gel_gid="1";}
	else{ $gel_gid="0"; }
 	 
	 	$insert=array(
	'islem_turu'=>$is_t,
	'relation_type'=>$rel_t,
	'relation_id'=>$fat_id,
	'giris_cikis'=>$gir_cik,
	'tutar'=>$toplam,
	'tarih'=>$duz_ta,
	'aciklama'=>$ack,
	'cari_id'=>$mus,
	'kullanici_id'=>$kul_id,	
	'gelir_gider_fat'=>$gel_gid,
	);	

	
	$this->db->insert('islem',$insert);	
	return $this->db->insert_id();	  
   


    }
	
function islem_gunc_fat($fat_id,$is_t,$rel_t,$fat_id,$gir_cik,$toplam,$duz_ta,$ack,$mus,$kul_id)
    { 
   
   
 	 
	 	$insert=array(
	'islem_turu'=>$is_t,
	'relation_type'=>$rel_t,
	'relation_id'=>$fat_id,
	'giris_cikis'=>$gir_cik,
	'tutar'=>$toplam,
	'tarih'=>$duz_ta,
	'aciklama'=>$ack,
	'cari_id'=>$mus,
	'kullanici_id'=>$kul_id,	

	);	

	$this->db->where('relation_id',$fat_id);	
	$this->db->where('islem_turu',4);		
	$this->db->update('islem',$insert);	
//	return $this->db->insert_id();	  
   
return TRUE;

    }


 






     function irs_getir($mus,$fat_turu,$kul_id)
    { 
        $sql = "SELECT * FROM irsaliye Where kullanici_id=".$kul_id." and fatura_turu='$fat_turu' and cari_id=".$mus;
        $query = $this->db->query($sql);

        if( $query->num_rows() > 0 )
        {
            return $query->result_array();
        }
        else
        {
            return FALSE;
        }



    }








 function islem_kayit_tahsilat_odeme($is_t,$rel_t,$fat_id,$gir_cik,$toplam,$duz_ta,$ack,$mus,$kasa,$fat_turu,$kul_id)
    { 
   
	if($fat_turu=="Gider"){ $gel_gid="1";}
	else{ $gel_gid="0"; }
 
 	 
	 	$insert=array(
	'islem_turu'=>$is_t,
	'relation_type'=>$rel_t,
	'relation_id'=>$fat_id,
	'giris_cikis'=>$gir_cik,
	'tutar'=>$toplam,
	'tarih'=>$duz_ta,
	'aciklama'=>$ack,
	'cari_id'=>$mus,
	'kasa_id'=>$kasa,	
	'kullanici_id'=>$kul_id,
	'gelir_gider_fat'=>$gel_gid,

	);	
	
	$this->db->insert('islem',$insert);	
	return $this->db->insert_id();	  
   


    }



	
	 	      function fat_item_kayit($fat_id,$item,$qty,$prc,$total,$des,$discount,$tax,$fat_turu,$kul_id)
    { 
   
   
 	 
	 	$insert=array(
	'fatura_id'=>$fat_id,
	'fatura_turu'=>$fat_turu,	
	'hizmet_urun_id'=>$item,
	'adet'=>$qty,
	'birim_fiyat'=>$prc,
	'tutar'=>$total,
	'aciklama'=>$des,
	'indirim'=>$discount,
	'vergi'=>$tax,
	'kullanici_id'=>$kul_id

	);	
	
	$this->db->insert('fatura_item',$insert);	
	return $this->db->insert_id();	  
   


    }
	 
	 



     function irs_kayit($fat_turu,$mus,$no,$duz_ta,$va_ta,$il,$adr,$ack,$kul_id)
    { 
   

 	 
	 	$insert=array(
	'fatura_turu'=>$fat_turu,
	'kullanici_id'=>$kul_id,
	'cari_id'=>$mus,
	'tarih'=>$duz_ta,
	'vade_tarihi'=>$va_ta,
	'il'=>$il,
	'adres'=>$adr,	
	'irsaliye_no'=>$no,
	'aciklama'=>$ack,

	);	
	
	$this->db->insert('irsaliye',$insert);	
	return $this->db->insert_id();	  
   


    }
	 
	
	

     function irs_guncelle($fat_id,$fat_turu,$mus,$no,$duz_ta,$va_ta,$il,$adr,$ack,$kul_id)
    { 
   

 	 
	 	$insert=array(
	'fatura_turu'=>$fat_turu,
	'kullanici_id'=>$kul_id,
	'cari_id'=>$mus,
	'tarih'=>$duz_ta,
	'vade_tarihi'=>$va_ta,
	'il'=>$il,
	'adres'=>$adr,	
	'irsaliye_no'=>$no,
	'aciklama'=>$ack,

	);	
		$this->db->where('id',$fat_id);	
	$this->db->update('irsaliye',$insert);	
//	return $this->db->insert_id();	  
   
	$this->db->where('fatura_id',$fat_id);	
	$this->db->delete('irsaliye_item');

return TRUE;
    }
	
	 	      function irs_item_kayit($fat_id,$item,$qty,$des,$kul_id)
    { 
   
   
 	 
	 	$insert=array(
	'fatura_id'=>$fat_id,
	'hizmet_urun_id'=>$item,
	'adet'=>$qty,
	'aciklama'=>$des,
	'kullanici_id'=>$kul_id

	);	
	
	$this->db->insert('irsaliye_item',$insert);	
	return $this->db->insert_id();	  
   


    }



  	 function 	 	 urun_hizmet_adi_getir($id,$kul_id) 
     { 		 

		$query =$this->db->query("select * from hizmet_urun Where id=".$id." and kullanici_id=".$kul_id);
		foreach ($query->result_array() as $row)
		{
        return $row['adi'];
		}	
	
	
	 }



	 
	   	 function 	 	 stok_baslangic($id,$kul_id) 
     { 		 

		$query =$this->db->query("select * from hizmet_urun Where id=".$id." and kullanici_id=".$kul_id);
		foreach ($query->result_array() as $row)
		{
        return $row['bas_stok'];
		}	
	
	
	 }

	 	  	 function 	 	 stok_toplam_getir($id,$kul_id) 
     { 		 
			$query =$this->db->query("select * from fatura_item Where hizmet_urun_id=".$id." and kullanici_id=".$kul_id);
        if( $query->num_rows() > 0 )
        {
            return $query->result_array();
        }
        else
        {
            return FALSE;
        }
	
	
	 } 
	 	 	 
	 	 	  	 function 	 	 irs_toplam_getir($id,$kul_id) 
     { 		 
			$query =$this->db->query("select * from irsaliye_item Where hizmet_urun_id=".$id." and kullanici_id=".$kul_id);
        if( $query->num_rows() > 0 )
        {
            return $query->result_array();
        }
        else
        {
            return FALSE;
        }
	
	
	 } 
	 
	 
	    	 function 	 	 fatura_turu_getir($f_id,$kul_id) 
     { 		 

		$query =$this->db->query("select * from fatura Where id=".$f_id." and kullanici_id=".$kul_id);
		foreach ($query->result_array() as $row)
		{
        return $row['fatura_turu'];
		}	
	
	
	 }


	   	 function 	 	 fatura_cari_id_getir($f_id,$kul_id) 
     { 		 

		$query =$this->db->query("select * from fatura Where id=".$f_id." and kullanici_id=".$kul_id);
		foreach ($query->result_array() as $row)
		{
        return $row['cari_id'];
		}	
	
	
	 }



	   	 function cek_bilgi_getir($kul_id,$id) 
     { 		 

		$sql = "SELECT * FROM cek_senet Where id=".$id." and kullanici_id=".$kul_id;
        $query = $this->db->query($sql);

        if( $query->num_rows() > 0 )
        {
            return $query->result_array();
        }
        else
        {
            return FALSE;
        }
	
	
	 }

	


	 	    	 function 	 	 fatura_turu_getir_irs($f_id,$kul_id) 
     { 		 

		$query =$this->db->query("select * from irsaliye Where id=".$f_id." and kullanici_id=".$kul_id);
		foreach ($query->result_array() as $row)
		{
        return $row['fatura_turu'];
		}	
	
	
	 }



	 	    	 function 	 	 fatura_tar_getir_irs($f_id,$kul_id) 
     { 		 

		$query =$this->db->query("select * from irsaliye Where id=".$f_id." and kullanici_id=".$kul_id);
		foreach ($query->result_array() as $row)
		{
        return $row['tarih'];
		}	
	
	
	 }


	 	    	 function 	 	 fatura_tar_getir_fat($f_id,$kul_id) 
     { 		 

		$query =$this->db->query("select * from fatura Where id=".$f_id." and kullanici_id=".$kul_id);
		foreach ($query->result_array() as $row)
		{
        return $row['tarih'];
		}	
	
	
	 }


	 	    	 function 	 	 fatura_irs_durum_getir_fat($f_id,$kul_id) 
     { 		 


		$query =$this->db->query("select * from fatura Where id=".$f_id." and kullanici_id=".$kul_id);
		foreach ($query->result_array() as $row)
		{
        return $row['irsaliye_durum'];
		}	
	
	
	 }
	 
	 
	  	 	 	 function 	 	 yetki_kontrol_stok_detay($kul_id,$id) 
     { 		 
			$query =$this->db->query("select * from hizmet_urun Where id=".$id." and kullanici_id=".$kul_id."");
        if( $query->num_rows() > 0 )
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }

	
	
	 } 
	 
	 
	 
	 
	 
	  	   	 function 	 	 stok_adi($id,$kul_id) 
     { 		 

		$query =$this->db->query("select * from hizmet_urun Where id=".$id." and kullanici_id=".$kul_id);
		foreach ($query->result_array() as $row)
		{
        return $row['adi'];
		}	
	
	
	 } 
	 
	 
	  
	  	   	 function 	 	 gider_kat_adi($id,$kul_id) 
     { 		 

		$query =$this->db->query("select * from gider_kategori Where id=".$id." and kullanici_id=".$kul_id);
		foreach ($query->result_array() as $row)
		{
        return $row['adi'];
		}	
	
	
	 }
	 
	 
	 	     function fatura_getir_duzenle($id,$kul_id)
    {

        $sql = "SELECT * FROM fatura Where id=".$id." and kullanici_id=".$kul_id;
        $query = $this->db->query($sql);

        if( $query->num_rows() > 0 )
        {
            return $query->result_array();
        }
        else
        {
            return FALSE;
        }




    }
	 
	 
	 	 	     function irsaliye_getir_duzenle($id,$kul_id)
    {

        $sql = "SELECT * FROM irsaliye Where id=".$id." and kullanici_id=".$kul_id;
        $query = $this->db->query($sql);

        if( $query->num_rows() > 0 )
        {
            return $query->result_array();
        }
        else
        {
            return FALSE;
        }




    }



 	 	     function iliski_irs_getir($kul_id)
    {

        $sql = "SELECT irs_id FROM fat_irs_iliski Where kullanici_id=".$kul_id." GROUP BY irs_id";
        $query = $this->db->query($sql);

        if( $query->num_rows() > 0 )
        {
            return $query->result_array();
        }
        else
        {
            return FALSE;
        }




    }



    	     function iliskili_fat_getir($irs_id,$kul_id)
    {

        $sql = "SELECT fat_id FROM fat_irs_iliski Where irs_id=".$irs_id." and kullanici_id=".$kul_id." GROUP BY fat_id";
        $query = $this->db->query($sql);

        if( $query->num_rows() > 0 )
        {
            return $query->result_array();
        }
        else
        {
            return FALSE;
        }




    }

 	    	     function iliski_ft_getir($kul_id)
    {

        $sql = "SELECT fat_id FROM fat_irs_iliski Where kullanici_id=".$kul_id." GROUP BY fat_id";
        $query = $this->db->query($sql);

        if( $query->num_rows() > 0 )
        {
            return $query->result_array();
        }
        else
        {
            return FALSE;
        }




    }

 	

	 	     function urunler_irs_item_adet($ur_id,$fat_id,$kul_id)
    {


        	$this->db->select_sum('adet');
			$this->db->from('irsaliye_item');
			$this->db->where('hizmet_urun_id', $ur_id);
			$this->db->where('fatura_id', $fat_id);		
			$this->db->where('kullanici_id', $kul_id);			
			$query = $this->db->get();
			if(!$query->row()->adet){return 0;}	
			return $irs_top=$query->row()->adet;	



    }

 	   
function urunler_irs_fat_item_adet($ur_id,$fat_id,$kul_id)
    {


    $sql = "SELECT fat_id FROM fat_irs_iliski Where irs_id=".$fat_id." and kullanici_id=".$kul_id;
        $query = $this->db->query($sql);

        if( $query->num_rows() > 0 )
        {
            $iliskili_faturalar=$query->result_array();
        }
        else
        {
            $iliskili_faturalar=FALSE;
        }


 		  $adet=0;
           $n=0; if( $iliskili_faturalar ) :  foreach( $iliskili_faturalar as $dizi2 ) :




        	$this->db->select_sum('adet');
			$this->db->from('fatura_item');
			$this->db->where('hizmet_urun_id', $ur_id);
			$this->db->where('fatura_id', $dizi2["fat_id"]);		
			$this->db->where('kullanici_id', $kul_id);	
				
			$query = $this->db->get();
			if(!$query->row()->adet){}	
			$adet=$adet+$query->row()->adet;


           	$n=$n+1; endforeach;  endif;


			return $adet;



    }




	     function urunler_ft_item_adet($ur_id,$fat_id,$kul_id)
    {


        	$this->db->select_sum('adet');
			$this->db->from('fatura_item');
			$this->db->where('hizmet_urun_id', $ur_id);
			$this->db->where('fatura_id', $fat_id);		
			$this->db->where('kullanici_id', $kul_id);			
			$query = $this->db->get();
			if(!$query->row()->adet){return 0;}	
			return $irs_top=$query->row()->adet;	



    }

 	



function urunler_fat_irs_item_adet($ur_id,$fat_id,$kul_id)
    {


    $sql = "SELECT irs_id FROM fat_irs_iliski Where fat_id=".$fat_id." and kullanici_id=".$kul_id;
        $query = $this->db->query($sql);

        if( $query->num_rows() > 0 )
        {
            $iliskili_irsaliyeler=$query->result_array();
        }
        else
        {
            $iliskili_irsaliyeler=FALSE;
        }


 		  $adet=0;
           $n=0; if( $iliskili_irsaliyeler ) :  foreach( $iliskili_irsaliyeler as $dizi2 ) :




        	$this->db->select_sum('adet');
			$this->db->from('irsaliye_item');
			$this->db->where('hizmet_urun_id', $ur_id);
			$this->db->where('fatura_id', $dizi2["irs_id"]);		
			$this->db->where('kullanici_id', $kul_id);	
				
			$query = $this->db->get();
			if(!$query->row()->adet){}	
			$adet=$adet+$query->row()->adet;


           	$n=$n+1; endforeach;  endif;


			return $adet;



    }



	 
	 	     function fatura_item_getir_duzenle($id,$kul_id)
    {

        $sql = "SELECT * FROM fatura_item Where fatura_id=".$id." and kullanici_id=".$kul_id;
        $query = $this->db->query($sql);

        if( $query->num_rows() > 0 )
        {
            return $query->result_array();
        }
        else
        {
            return FALSE;
        }




    }


	 
	

	 	     function irsaliye_item_getir_duzenle($id,$kul_id)
    {

        $sql = "SELECT * FROM irsaliye_item Where fatura_id=".$id." and kullanici_id=".$kul_id;
        $query = $this->db->query($sql);

        if( $query->num_rows() > 0 )
        {
            return $query->result_array();
        }
        else
        {
            return FALSE;
        }




    }



 	     function secili_irs_item_say($id,$kul_id)
    {

        $sql = "SELECT * FROM irsaliye_item Where fatura_id=".$id." and kullanici_id=".$kul_id;
        $query = $this->db->query($sql);

        return $query->num_rows() ;
     


    }








	    function fatura_odeme_getir($id,$kul_id)
    {

        $sql = "SELECT * FROM islem Where islem_turu=3 and relation_id=".$id." and kullanici_id=".$kul_id;
        $query = $this->db->query($sql);

        if( $query->num_rows() > 0 )
        {
            return $query->result_array();
        }
        else
        {
            return FALSE;
        }




    } 


        function fatura_cek_getir($id,$kul_id)
    {

        $sql = "SELECT * FROM islem Where islem_turu=5 and kullanici_id=".$kul_id;
        $query = $this->db->query($sql);

        if( $query->num_rows() > 0 )
        {
            return $query->result_array();
        }
        else
        {
            return FALSE;
        }




    } 



        function fatura_iade_getir($id,$kul_id)
    {

        $sql = "SELECT * FROM islem Where islem_turu=4 and kullanici_id=".$kul_id;
        $query = $this->db->query($sql);

        if( $query->num_rows() > 0 )
        {
            return $query->result_array();
        }
        else
        {
            return FALSE;
        }


    }


      function iade_kontrol($r_id,$id,$kul_id)
    {

        $sql = "SELECT * FROM fatura Where id=".$r_id." and kullanici_id=".$kul_id;
        $query = $this->db->query($sql);


		foreach ($query->result_array() as $row)
		{
        $iade_fat=$row['iade_fat'];
		}	

        if( $iade_fat == $id )
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }


    }




    function fatura_irsaliye_getir($id,$kul_id)
    {

        $sql = "SELECT irs_id FROM fat_irs_iliski Where fat_id=".$id." and kullanici_id=".$kul_id." GROUP BY irs_id";
        $query = $this->db->query($sql);

        if( $query->num_rows() > 0 )
        {
            return $query->result_array();
        }
        else
        {
            return FALSE;
        }




    }

	


    function irsaliye_fatura_getir($id,$kul_id)
    {

        $sql = "SELECT fat_id FROM fat_irs_iliski Where irs_id=".$id." and kullanici_id=".$kul_id." GROUP BY fat_id";
        $query = $this->db->query($sql);

        if( $query->num_rows() > 0 )
        {
            return $query->result_array();
        }
        else
        {
            return FALSE;
        }




    }

	



 function irs_detay_getir($irs_id,$kul_id)
    {

        $sql = "SELECT * FROM irsaliye Where id=".$irs_id." and kullanici_id=".$kul_id;
        $query = $this->db->query($sql);

        if( $query->num_rows() > 0 )
        {
            return $query->result_array();
        }
        else
        {
            return FALSE;
        }




    }






 function fat_detay_getir($fat_id,$kul_id)
    {

        $sql = "SELECT * FROM fatura Where id=".$fat_id." and kullanici_id=".$kul_id;
        $query = $this->db->query($sql);

        if( $query->num_rows() > 0 )
        {
            return $query->result_array();
        }
        else
        {
            return FALSE;
        }




    }








		 	   	 function yetki_kontrol_fatura($id,$kul_id) 
     { 		 
			$query =$this->db->query("select * from fatura Where id=".$id." and kullanici_id=".$kul_id);
        if( $query->num_rows() > 0 )
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }

	
	
	 } 




		 	   	 function yetki_kontrol_irsaliye($id,$kul_id) 
     { 		 
			$query =$this->db->query("select * from irsaliye Where id=".$id." and kullanici_id=".$kul_id);
        if( $query->num_rows() > 0 )
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }

	
	
	 } 


   function fat_sil($f_id)
    


{

	$this->db->where('id',$f_id);	
	$this->db->delete('fatura');	

	$this->db->where('fatura_id',$f_id);	
	$this->db->delete('fatura_item');

	$this->db->where('relation_id',$f_id);	
	$this->db->where('islem_turu',4);	
	$this->db->delete('islem');

	return TRUE;


        $sql1 = "DELETE FROM fatura Where id=".$f_id;
        $sql2 = "DELETE FROM fatura_item Where fatura_id=".$f_id;
        $sql3 = "DELETE FROM islem Where islem_turu=4 and relation_id=".$f_id;



return TRUE;



    }




  function irs_sil($f_id)
    


{

	$this->db->where('id',$f_id);	
	$this->db->delete('irsaliye');	

	$this->db->where('fatura_id',$f_id);	
	$this->db->delete('irsaliye_item');



	return TRUE;


        $sql1 = "DELETE FROM fatura Where id=".$f_id;
        $sql2 = "DELETE FROM fatura_item Where fatura_id=".$f_id;
        $sql3 = "DELETE FROM islem Where islem_turu=4 and relation_id=".$f_id;



return TRUE;



    }

	 
	 







    
              function fat_irs_iliski_kaydet($fat_id,$irs_id,$kul_id)
     {

	
	$insert=array(
	'fat_id'=>$fat_id,
	'irs_id'=>$irs_id,
//	'irs_item_id'=>$item_id,
//	'adet'=>$adet,
	'kullanici_id'=>$kul_id	
	
	);
	
	$into=$this->db->insert('fat_irs_iliski',$insert);
	if($into){
return TRUE;
	
	}
		return FALSE;
	
	




     }



   



  	 function irs_fat_durum($id,$kul_id) 
     { 		 
//   "select * from fat_irs_iliski Where irs_id=".$id." and kullanici_id=".."


		$query =$this->db->query("select * from fat_irs_iliski Where irs_id=".$id."  and kullanici_id=".$kul_id."");
        
        if( $query->num_rows() > 0 )
        {
            return 0;
        }
        else
        {
            return 1;
        }



	
	
	 }




  	 function irs_item_bilgi($id,$kul_id) 
     { 		 

		$query =$this->db->query("select fat_id,irs_id from fat_irs_iliski Where irs_id=".$id." and kullanici_id=".$kul_id);

	//	return $query->num_rows();

        if( $query->num_rows() > 0 )
        {
            return $query->result_array();
        }
        else
        {
            return FALSE;
        }


        
 


	
	
	 }


	  	 function irs_urun_getir($id,$kul_id) 
     { 		 

		$query =$this->db->query("select hizmet_urun_id from irsaliye_item Where fatura_id=".$id." and kullanici_id=".$kul_id." GROUP BY hizmet_urun_id");

	//	return $query->num_rows();

        if( $query->num_rows() > 0 )
        {
            return $query->result_array();
        }
        else
        {
            return FALSE;
        }


 

	
	
	 }



	 	  	 function irs_urun_top($id,$ur_id,$kul_id) 
     { 		 

     			//, $fat_id
			$this->db->select('hizmet_urun_id');
			$this->db->select_sum('adet');
			$this->db->from('irsaliye_item');
			$this->db->where('fatura_id', $id);			
			$this->db->where('hizmet_urun_id', $ur_id);	
			$this->db->where('kullanici_id', $kul_id);	
					
			$query = $this->db->get();
			if(!$query->row()->adet){return 0;}	
			return $query->row()->adet;
 


	
	
	 }



/*

  	 function irs_item_urun_adet_getir($id,$kul_id) 
     { 		 

		$query =$this->db->query("select fatura_id,hizmet_urun_id,adet from irsaliye_item Where id=".$id." and kullanici_id=".$kul_id);

	//	return $query->num_rows();

        if( $query->num_rows() > 0 )
        {
            return $query->result_array();
        }
        else
        {
            return FALSE;
        }


        
 


	
	
	 }


	
*/










		function irs_item_top( $irs_item_id) {

			//, $fat_id
			$this->db->select_sum('adet');
			$this->db->from('fat_irs_iliski');
			$this->db->where('irs_item_id', $irs_item_id);
			$query = $this->db->get();
			if(!$query->row()->adet){return 0;}	
			$irs_ils_top=$query->row()->adet;					
			
		
			$this->db->select_sum('adet');
			$this->db->from('irsaliye_item');
			$this->db->where('id', $irs_item_id);
			$query = $this->db->get();
			if(!$query->row()->adet){return 0;}	
			$irs_top=$query->row()->adet;		
			
			$sonuc=$irs_top-$irs_ils_top;

			if($sonuc==$irs_top){
				return "Açık";
			}
			if($sonuc<=0){
				return "Kapalı";
			}

			if($sonuc<$irs_top){
				return "Kısmı";
			}
		

	
			}




 	 	 function cek_fat_id_getir($id,$kul_id)
     {
	
		$query =$this->db->query("select * from cek_senet Where id=".$id);
        if( $query->num_rows() > 0 )
        {
            
					foreach ($query->result_array() as $row)
										{
										return $row['fat_id'];	
							
										}
			
        }
        else
        {
            return FALSE;
        }
	
	 } 	




}
?>