<?php
class GF
{
	private static $reload = '';
	public static function HD($url)
	{
		header('HTTP/1.1 303 See Other');
		header("Location: ".$url);
		exit;
	}
	public static function TMSG($msg,$url='',$xy='true',$dtime=0){
		ACT::Cinit();
		T::A('modname','温馨提示');
		T::A("xy",$xy);
		T::A("msg",$msg);
		T::A('href',$url);
		T::A('dtime',$dtime>0?$dtime:$CONF->APP['redirecttime']);
		T::A("reload",(self::$reload=='')?'':".".self::$reload);
		T::A("ftop","true");
		T::P('msg.htm');
		exit();
	}
	public static function MSG($msg,$url='',$xy='true',$dtime=0)
	{
		global $CONF;
		ACT::Cinit();
		T::A('modname','温馨提示');
		T::A("xy",$xy);
		T::A("msg",$msg);
		T::A('href',$url);
		T::A('dtime',$dtime !=0 ?$dtime:$CONF->APP['redirecttime']);
		T::A("ftop","false");
		T::A("reload",(self::$reload=='')?'':".".self::$reload);
		T::P('msg.htm');

		exit();
	}
	public static function R($p)
	{
		self::$reload = $p;
	}
	public static function LOGIN($url)
	{
		$str  = '<script language="javascript">';
		$str .= "\r\n top.location.href='{$url}';\r\n";
		$str .= '</script>';
		exit($str);
	}
	public static function FEXT($exp){
		$ExpArr = array(
			'image/gif' =>'.gif',
			'image/png' =>'.png',
			'image/xpng' => '.png',
			'image/jpeg' =>'.jpg',
			'image/jpg' => '.jpg',
			'image/jpeg'=>'.jpeg'
			);
		if( isset($ExpArr[$exp]) )
			return $ExpArr[$exp];
		else
			return $exp;
	}
	public static function MIME($exp){
		$ExpArr = array(
			'.jpg' =>'images',
			'.gif' =>'image/gif',
			'.png' =>'image/png',
			'.jpg' =>'image/jpeg',
			'.jpeg'=>'image/jpeg'
			);
		if( isset($ExpArr[$exp]) )
			return $ExpArr[$exp];
		else
			return $exp;
	}
	public static function DeURL($url){
		$url = strtolower($url);
		$s = str_replace("&amp;","&",$url);
		if($s == $url)
			return $s;
		else
			return GF::DeURL($s);
	}

	public static function JO($obj1,$obj2){
		foreach($obj2 as $key => $val){
			if(!isset($obj1->$key))
				$obj1->$key = $val;
		}
		return $obj1;
	}
	public static function JSON($a){
//		$code = json_encode($obj);
//		$code = preg_replace("#\\\u([0-9a-f]+)#ie", "iconv('UCS-2', 'UTF-8', pack('H4', '\\1'))", $code);
//		$code = urldecode($code);
//		return $code;
		if (is_null($a)) return 'null';
		if ($a === false) return 'false';
		if ($a === true) return 'true';
		if (is_scalar($a)) {
			if (is_float($a)) {
			// Always use "." for floats.
				return floatval(str_replace(",", ".", strval($a)));
			}

			if (is_string($a)) {
				static $jsonReplaces = array(array("\\", "\n", "\t", "\r", "\b", "\f", '"'), array('\\\\',  '\\n', '\\t', '\\r', '\\b', '\\f', '\"'));
				return '"' . str_replace($jsonReplaces[0], $jsonReplaces[1], $a) . '"';
			} else {
				return $a;
			}
		}

		$isList = true;
		for ($i = 0, reset($a); $i < count($a); $i++, next($a)) {
			if (key($a) !== $i) {
				$isList = false;
				break;
			}
		}

		$result = array();
		if ($isList) {
			foreach ($a as $v) $result[] = GF::JSON($v);
			return '[' . join(',', $result) . ']';
		} else {
			foreach ($a as $k => $v) $result[] = GF::JSON($k).':'.GF::JSON($v);
			return '{' . join(',', $result) . '}';
		}
	}
	public static function PCT($provid,$cityid=0,$townid=0){
		$ret = new stdClass();
		if( $cityid && $townid )
		$sql = "select p.prov,c.city,t.* from regionprov as p ,regioncity as c,regiontown as t where p.provid='{$provid}' and c.cityid='{$cityid}' and t.townid='{$townid}' and t.provid=p.provid and t.cityid=c.cityid";
		else
			if( $cityid )
				$sql = "select p.prov,c.* from regionprov as p,regioncity as c where p.provid='{$provid}' and c.cityid='{$cityid}' and c.provid=p.provid";
			else
				$sql = "select * from regionprov where provid='{$provid}'";
		$q = DB::Q($sql);
		return DB::O($q);
	}
	public static function CODE(){
		header( "Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
		header( "Last-Modified: ".gmdate( "D, d M Y H:i:s" )."GMT" );
		header( "Cache-Control: no-cache, must-revalidate" );
		header( "Pragma: no-cache" );
		error_reporting( E_ERROR | E_WARNING | E_PARSE );
		$verify = new verifycode( );
		$code = rand(1111,9999);
		$code = strrev( $code ) + 5 * 2 - 9;
		$code = substr( $code, 0, 4 );
		$_SESSION['codeimgsrc'] = $code;
		$verify->vcode( $code );
		$verify->output( );
	}
	public static function PCTJS($f){
		global $CONF;
		$path = TTROOT."/template/js";
		$file = $path."/".$f;
		if( !file_exists($file) || ( $CONF->AccTimes - filemtime($file) > $CONF->CacheTime ) ){
			$js = "var provArr = new Array();\r\nvar cityArr = new Array();\r\nvar townArr = new Array();\r\n";
			$Q = DB::Q("select * from regionprov");
			$c=0;
			while ($p = DB::O($Q)){
				$js .= "provArr[".$c++."] = new Array('{$p->provid}','{$p->prov}');\r\n";
			}
			$c=0;
			$Q = DB::Q("select * from regioncity");
			while($o=DB::O($Q)){
				$js .= "cityArr[".$c++."] = new Array('{$o->cityid}','{$o->city}','{$o->provid}');\r\n";
			}
			$c=0;
			$Q = DB::Q("select * from regiontown");
			while ($o=DB::O($Q)){
				$js .= "townArr[".$c++."] = new Array('{$o->townid}','{$o->town}','{$o->cityid}','{$o->provid}');\r\n";
			}
			file_put_contents($file,$js);
		}
		return "<script src='{$CONF->PROJECT['template']}/{$f}'></script>\r\n";
	}
	public static function MT(){
		list($m,$t) = explode(" ",microtime());
		return ($t+$m)*10000;
	}
	public static function EM($email){
		$s = explode('@',$email);
		$l = strlen($s[0]);
		if($l<=3)
			$user = '***';
		else if( $l>3 && $l<6)
			$user = substr($email,0,1)."****";
		else
			$user = substr($email,0,1).'****'.substr($s[0],-1);
		return $user."@".$s[1];
	}
}

class verifycode
{

				var $Noisy = 5;
				var $Count = 4;
				var $Width = 60;
				var $Height = 18;
				var $Angle = 2;
				var $Offset = 20;
				var $Border = 1;
				var $imgData = "";
				var $Graph = array( );
				var $code = "";

				function vcode( $code )
				{
								global $code;
								$this->code = $code;
								$i = 0;
								for ( ;	$i < strlen( $code );	$i++	)
								{
												$this->setdraw( substr( $code, $i, 1 ), $i );
								}
				}

				function setdot( $pX, $pY )
				{
								if ( 0 <= $pX * ( $this->Width - $pX - 1 ) && 0 <= $pY * ( $this->Height - $pY - 1 ) )
								{
												$this->Graph[$pX][$pY] = 1;
								}
				}

				function rnd( )
				{
//								mt_srand( ( double ) * 1000000 );
								return mt_rand( 1, 999 ) / 1000;
				}

				function sgn( $v )
				{
								if ( 0 < $v )
								{
												return 1;
								}
								if ( $v == 0 )
								{
												return 0;
								}
								if ( $v < 0 )
								{
												return 0 - 1;
								}
				}

				function setdraw( $pIndex, $pNumber )
				{
								$DotData[0] = array( 10, 1, 80, 1, 80, 100, 10, 100, 10, 1 );
								$DotData[1] = array( 30, 15, 50, 1, 50, 100 );
								$DotData[2] = array( 1, 34, 30, 1, 71, 1, 100, 34, 1, 100, 93, 100, 100, 86 );
								$DotData[3] = array( 1, 1, 100, 1, 42, 42, 100, 70, 50, 100, 1, 70 );
								$DotData[4] = array( 100, 73, 6, 73, 75, 6, 75, 100 );
								$DotData[5] = array( 100, 1, 1, 1, 1, 50, 50, 35, 100, 55, 100, 80, 50, 100, 1, 95 );
								$DotData[6] = array( 100, 20, 70, 1, 20, 1, 1, 30, 1, 80, 30, 100, 70, 100, 100, 80, 100, 60, 70, 50, 30, 50, 1, 60 );
								$DotData[7] = array( 6, 26, 6, 6, 100, 6, 53, 100 );
								$DotData[8] = array( 100, 30, 100, 20, 70, 1, 30, 1, 1, 20, 1, 30, 100, 70, 100, 80, 70, 100, 30, 100, 1, 80, 1, 70, 100, 30 );
								$DotData[9] = array( 1, 80, 30, 100, 80, 100, 100, 70, 100, 20, 70, 1, 30, 1, 1, 20, 1, 40, 30, 50, 70, 50, 100, 40 );
								$vExtent = $this->Width / strlen( $this->code );
								$Margin[0] = $this->Border + $vExtent * $pNumber + $vExtent * ( $this->rnd( ) * $this->Offset ) / 100;
								$Margin[1] = $vExtent * ( $pNumber + 1 ) - $this->Border - $vExtent * ( $this->rnd( ) * $this->Offset ) / 100;
								$Margin[2] = $this->Border + $this->Height * ( $this->rnd( ) * $this->Offset ) / 100;
								$Margin[3] = $this->Height - $this->Border - $this->Height * ( $this->rnd( ) * $this->Offset ) / 100;
								$vWidth = intval( $Margin[1] - $Margin[0] );
								$vHeight = intval( $Margin[3] - $Margin[2] );
								$vStartX = intval( ( $DotData[$pIndex][0] - 1 ) * $vWidth / 100 );
								$vStartY = intval( ( $DotData[$pIndex][1] - 1 ) * $vHeight / 100 );
								$i = 1;
								for ( ;	$i <= count( $DotData[$pIndex] ) / 2;	$i++	)
								{
												if ( $DotData[$pIndex][2 * $i - 2] != 0 && $DotData[$pIndex][2 * $i] != 0 )
												{
																$vEndX = ( $DotData[$pIndex][2 * $i] - 1 ) * $vWidth / 100;
																$vEndY = ( $DotData[$pIndex][2 * $i + 1] - 1 ) * $vHeight / 100;
																$vDX = $vEndX - $vStartX;
																$vDY = $vEndY - $vStartY;
																if ( $vDX == 0 )
																{
																				$vAngle = $this->sgn( $vDY ) * 3.14 / 2;
																}
																else
																{
																				$vAngle = atan( $vDY / $vDX );
																}
																if ( sin( $vAngle ) == 0 )
																{
																				$vLength = $vDX;
																}
																else
																{
																				$vLength = $vDY / sin( $vAngle );
																}
																$vAngle = $vAngle + ( $this->rnd( ) - 0.5 ) * 2 * $this->Angle * 3.14 * 2 / 100;
																$vDX = intval( cos( $vAngle ) * $vLength );
																$vDY = intval( sin( $vAngle ) * $vLength );
																if ( abs( $vDY ) < abs( $vDX ) )
																{
																				$vDeltaT = abs( $vDX );
																}
																else
																{
																				$vDeltaT = abs( $vDY );
																}
																$j = 1;
																for ( ;	$j <= $vDeltaT;	$j++	)
																{
																				$this->setdot( $Margin[0] + $vStartX + $j * $vDX / $vDeltaT, $Margin[2] + $vStartY + $j * $vDY / $vDeltaT );
																}
																$vStartX = $vStartX + $vDX;
																$vStartY = $vStartY + $vDY;
												}
								}
				}

				function output( )
				{
								$out = "";
								$out .= "GIF";
								$out .= "89a";
								$out .= chr( $this->Width % 256 ).chr( $this->Width / 256 % 256 );
								$out .= chr( $this->Height % 256 ).chr( $this->Height / 256 % 256 );
								$out .= chr( 128 ).chr( 0 ).chr( 0 );
								$out .= chr( 238 ).chr( 238 ).chr( 238 );
								$out .= chr( 0 ).chr( 0 ).chr( 0 );
								$out .= ",";
								$out .= chr( 0 ).chr( 0 ).chr( 0 ).chr( 0 );
								$out .= chr( $this->Width % 256 ).chr( $this->Width / 256 % 256 );
								$out .= chr( $this->Height % 256 ).chr( $this->Height / 256 % 256 );
								$out .= chr( 0 ).chr( 7 ).chr( 255 );
								$y = 0;
								for ( ;	$y < $this->Height;	$y++	)
								{
												$x = 0;
												for ( ;	$x < $this->Width;	$x++	)
												{
																if ( $this->rnd( ) < $this->Noisy / 100 )
																{
																				$out .= chr( 1 - $this->Graph[$x][$y] );
																}
																else if ( $x * ( $x - $this->Width ) == 0 || $y * ( $y - $this->Height ) == 0 )
																{
																				$out .= chr( $this->Graph[$x][$y] );
																}
																else if ( $this->Graph[$x - 1][$y] == 1 || $this->Graph[$x][$y] || $this->Graph[$x][$y - 1] == 1 )
																{
																				$out .= chr( 1 );
																}
																else
																{
																				$out .= chr( 0 );
																}
																if ( ( $y * $this->Width + $x + 1 ) % 126 == 0 )
																{
																				$out .= chr( 128 );
																				$i++;
																}
																if ( ( $y * $this->Width + $x + $i + 1 ) % 255 == 0 )
																{
																				if ( 255 < $this->Width * $this->Height - $y * $this->Width - $x - 1 )
																				{
																								$out .= chr( 255 );
																				}
																				else
																				{
																								$out .= chr( $this->Width * $this->Height % 255 );
																				}
																}
												}
								}
								$out .= chr( 128 ).chr( 0 ).chr( 129 ).chr( 0 ).chr( 59 );
								header( "Expires: -9999" );
								header( "Pragma: no-cache" );
								header( "cache-ctrol: no-cache" );
								header( "ContentType: image/gif" );
								echo $out;
				}

}
?>