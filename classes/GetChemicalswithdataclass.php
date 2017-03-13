<?
//-------------------------------------------------------------------------------------------------
//    @name:      ChemicalsWithData
//    @purpose:   Responsible for creating XML for Chemicals Profiles
//    @category:  PHP Class
//    @author:    Greg E. Salivio 10/06/2014 started
//    @version:   1.0
//    @copyright: cdxlife.com
//
//-------------------------------------------------------------------------------------------------


//Module info Macros
define("GC_MODULE_NAME",            "Create an XML chemicals profiles");
define("GC_MODULE_NUMBER",          "1.0");

class ChemicalsWithData{
	public $strainid;
	public $profileid;
	public $userid;
	
	
	Public function GetChemicalsWithData($con,$profileid,$strainid){
		
		$sql="select * from ChemicalProfiles where ID=".$profileid;
	
		$result=mysql_query($sql);
		$userid="";
			while($row=mysql_fetch_array($result)){
				$profiledata.="<UserID>". $profileid."</UserID>";
				$profiledata.="<Name>".$row["Name"]. "</Name>";
				$profiledata.="<AmountIntake>" . $row["MethodIntake"] . "</AmountIntake>";
				$profiledata.="<FeelBefore>" . $row["FeelBefore"] . "</FeelBefore>";
				$profiledata.="<AmountIntake>" . $row["QtyIntake"] . "</AmountIntake>";
				$profiledata.="<LastedEffect>" . $row["EffectsLasted"] . "</LastedEffect>";
				$profiledata.="<Comments>" . $row["Comments"] . "</Comments>";
				$profiledata.="<Public>" . $row["IsPublic"]. "</Public>";
				$profiledata.="<PhotoName>" . $row["PhotoName"] ."</PhotoName>";
				
			}
		
			$profiledata="<Profiles>".$profiledata."</Profiles>";
		
		
		$sql="SELECT * from StrainChemicals where StrainID='" . $strain_id . "' ";
	
		$result = mysql_query($sql) ;
			$isfound=false;
			if(mysql_num_rows($result)>0)
				$isfound=true;
			if($isfound){
				$row=mysql_fetch_array($result);
				if($row["UserID"]==$userid)
					$isfound=false;
			}
			if($isfound){
				$msg= "FOUND***";
				}
			else
				$msg= "NOTFOUND**";
	
		$sql="SELECT c.*,IFNULL(sc.value,'') as Value FROM Chemicals c LEFT  JOIN 
			  StrainChemicals sc on c.ID=sc.ChemicalID and sc.StrainID='" . $strain_id ."' order by ID";
	
		$result = mysql_query($sql) ;
			
			while($row = mysql_fetch_array($result))
			{
				$strc.="<Id>".$row['ID']."</Id>";
				$strc.="<Name>". $row['Name']. "</Name>";
				$strc.="<Type>" . $row['Type'] . "</Type>";
				$strc.="<Unit>" . $row['Unit'] . "</Unit>";
				$strc.="<Value>" . $row['Value']. '</Value>';
	
			}
		
			$xml="<ChemicalComposition>".$strc."</ChemicalComposition>".$profiledata;
		
		$sql="select * from StrainFeelings where ChemicalProfileID=" . $profileid;
	
		$result=mysql_query($sql);
			while($row=mysql_fetch_array($result)){
					
				$strain.="<Energetic>".$row["Energetic"]."</Energetic>";
				$strain.="<Social>".$row["Social"]."</Social>";
				$strain.="<Focused>".$row["Focused"]."</Focused>";
				$strain.="<Relaxed>".$row["Relaxed"]."</Relaxed>";
				$strain.="<Happy>".$row["Happy"]."</Happy>";
				$strain.="<Creative>".$row["Creative"]."</Creative>";
				$strain.="<Sexual>". $row["Sexual"] ."</Sexual>";
			}
		
			$xml=$xml."<Feelings>".$strain."</Feelings>";
		
		$sql="select * from StrainRelief where ChemicalProfileID=" . $profileid;
		$result=mysql_query($sql);
			while($row=mysql_fetch_array($result)){
					
				$relief.="<Migrane>".$row["Migraines"]. "</Migrane>";
				$relief.="<Siezures>" . $row["Siezures"] . "</Siezures>";
				$relief.="<Pain>" . $row["Pain"]."</Pain>";
			}
		
		if($relief<>""){
			$xml=$xml."<AilmentsRelieved>".$relief."</AilmentsRelieved>";
		}else{
			$xml=$xml."<AilmentsRelieved>No Record</AilmentsRelieved>";
		}
		
		$sql="select * from ProfileMedical where ChemicalProfileID=" . $profileid;
		$result=mysql_query($sql);
		$i=0;
			while($row=mysql_fetch_array($result)){
				if($i>0)
				
					$cond.="<Condition>".$row["Condition"]. "</Condition>";
					$cond.="<Value>" . $row["Value"]."</Value>";
				
				$i++;
			}
		
		$xml=$xml."<MedicalProfile>".$cond."</MedicalProfile>";
	
		mysql_close($con);
		
		$xml="<ChemicalProfile pid='$profileid'>".$xml."</ChemicalProfile>";
		
		$xmlobj = new SimpleXMLElement($xml);
		
		return $xmlobj;
	
	}
}

?>
