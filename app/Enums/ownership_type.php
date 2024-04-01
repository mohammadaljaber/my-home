<?php
namespace App\Enums;

enum ownership_type :string
{
    case Court_Judgment ="Court_Judgment";//حكم محكمة
    case Green_Title_Dead ="Green_Title_Dead";//طابو اخضر
    case Agricultural_Green_Title_Dead="Agricultural_Green_Title_Dead";//طابو زراعي;
    case Housing_Title_Dead="Housing_Title_Dead";//طابو اسكان
    case Shares_Title_Dead="Shares_Title_Dead";//طابو اسهم
    case Outgight_Sale_Contract="Outgight_Sale_Contract";//عقد بيع قطعي 
    case Notary_Public_Agency="Notary_Public_Agency";//كاتب عدل

}


?>