<?php

namespace App\Http\Controllers;

use App\Bank;
use App\Banktable;
use App\DepartmentAndZone;
use App\Helpers\LogActivity;
use App\Member;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserProfileController extends Controller
{
    //
    public function showUserProfileForm()
    {
        //dd('Loading Form');
        $users = User::where('id','!=',Auth::id())->where('name','!=','Administrator')->pluck('name','id')->toArray();
        $banks = Banktable::pluck('bank_name','id')->toArray();
        $member = Member::where('user_id',Auth::id())->first();
        $departments = DepartmentAndZone::all();
        return view('dashboard.userProfile.updateUserProfile',compact('users','banks','member','departments'));
    }

    public function updateProfile(Request $request)
    {
            if(!$request->state){
                $validator = request()->validate([
                    'first_name' => 'required',
//                  'middle_name' => 'required',
                    'last_name' => 'required',
                    'residential_address' => 'required',
                    'office_location' => 'required',
                    'department' => 'required',
                    'gender' => 'required',
                    'designation' => 'required',
                    'state_of_origin' => 'required',
                    'lga' => 'required',
                    'town' => 'required',
                    'nok_fname' => 'required',
//                  'nok_mname' => 'required',
                    'nok_lname' => 'required',
                    'nok_tel' => 'required|min:11|max:11',
                    'nok_address' => 'required',
                    'nok_relationship' => 'required',
                    'referee_one' => 'required',
                    'referee_two' => 'required',
//                  'bank_name' => 'required',
                    'account_no' => 'required|min:10|max:10',
                    'account_name' => 'required',
                    'certification' => 'required',
                ]);

                if(!in_array('message',$validator)){
                    $updateMemberInfo = Member::where('user_id',Auth::id())->update([
                        'first_name' => $request->first_name,
                        'middle_name' => $request->middle_name,
                        'last_name' => $request->last_name,
                        'residential_address' => $request->residential_address,
                        'office_location' => $request->office_location,
                        'staff_no' =>$request->staff_no,
                        'department' => $request->department,
                        'gender' => $request->gender,
                        'designation' => $request->designation,
                        'state_of_origin' => $request->state_of_origin,
                        'lga' => $request->lga,
                        'town' => $request->town,
                        'nok_fname' => $request->nok_fname,
                        'nok_mname' => $request->nok_mname,
                        'nok_lname' => $request->nok_lname,
                        'nok_phone_number' => $request->nok_tel,
                        'nok_address' => $request->nok_address,
                        'nok_relationship' => $request->nok_relationship,
                        'referee_one' => $request->referee_one,
                        'referee_two' => $request->referee_two,
                        'certification' => $request->certification,
                    ]);

                    $updateBankInfo = Bank::where('user_id',Auth::id())->update([
                        'bank_name' => $request->bank_name,
                        'account_no' => $request->account_no,
                        'account_name' => $request->account_name,
                    ]);
                    // dd($updateMemberInfo);
                    if($updateMemberInfo && $updateBankInfo){
                        $data = ['success' => true,'message'=> 'Profile Successfully Updated!'];
                        LogActivity::logUserActivity('User updated profile');
                        return response()->json($data);
                    }else{
                        $data = ['warning' => true, 'message'=> 'Something went wrong updating your profile!'];
                        return response()->json($data);
                    }

                }else {
                    return response()->json($validator);
            }

            }else{
                return $this->populateLocalGovernment($request);
            }

    }

    private function populateLocalGovernment(Request $request)
    {
       // dd($request->all());
        $stateArr = array(
            "Abia" => array("Aba North","Aba South","Arochukwu","Bende", "Ikwuano", "Isiala-Ngwa North", "Isiala-Ngwa South",
                "Isuikwato", "Obi Nwa", "Ohafia", "Osisioma", "Ngwa", "Ugwunagbo", "Ukwa East", "Ukwa West", "Umuahia North", "Umuahia South", "Umu-Neochi"),
            "Adamawa" => array("Demsa", "Fufore", "Ganaye", "Gireri", "Gombi", "Guyuk", "Hong", "Jada",
                "Lamurde", "Madagali", "Maiha", "Mayo-Belwa", "Michika", "Mubi North", "Mubi South",
                "Numan", "Shelleng", "Song", "Toungo", "Yola North", "Yola South"),
            "Anambra" => array( "Aguata", "Anambra East", "Anambra West", "Anaocha", "Awka North", "Awka South", "Ayamelum",
                "Dunukofia", "Ekwusigo", "Idemili North", "Idemili south", "Ihiala", "Njikoka", "Nnewi North", "Nnewi South",
                "Ogbaru", "Onitsha North", "Onitsha South", "Orumba North", "Orumba South", "Oyi"),
            "Akwa Ibom" => array("Abak", "Eastern Obolo", "Eket", "Esit Eket", "Essien Udim", "Etim Ekpo", "Etinan", "Ibeno",
                        "Ibesikpo Asutan", "Ibiono Ibom", "Ika", "Ikono", "Ikot Abasi", "Ikot Ekpene", "Ini", "Itu", "Mbo", "Mkpat Enin", "Nsit Atai", "Nsit Ibom", "Nsit Ubium", "Obot Akara",
                        "Okobo", "Onna", "Oron", "Oruk Anam", "Udung Uko", "Ukanafun", "Uruan", "Urue-Offong/Oruko ", "Uyo"),
            "Bauchi" => array("Alkaleri","Bauchi","Bogoro", "Damban", "Darazo", "Dass", "Ganjuwa", "Giade", "Itas/Gadau", "Jama'are", "Katagum", "Kirfi", "Misau", "Ningi", "Shira", "Tafawa-Balewa", "Toro", "Warji", "Zaki"),
            "Bayelsa" => Array("Brass", "Ekeremor", "Kolokuma/Opokuma", "Nembe", "Ogbia", "Sagbama", "Southern Jaw", "Yenegoa"),
            "Benue" => Array("Ado", "Agatu",
                "Apa", "Buruku", "Gboko", "Guma", "Gwer East", "Gwer West", "Katsina-Ala", "Konshisha", "Kwande", "Logo", "Makurdi", "Obi", "Ogbadibo", "Oju",
                "Okpokwu", "Ohimini", "Oturkpo", "Tarka", "Ukum", "Ushongo", "Vandeikya"),
            "Borno" => array("Abadam", "Askira/Uba", "Bama", "Bayo", "Biu", "Chibok", "Damboa", "Dikwa", "Gubio", "Guzamala", "Gwoza", "Hawul", "Jere", "Kaga",
                "Kala/Balge", "Konduga", "Kukawa", "Kwaya Kusar", "Mafa", "Magumeri", "Maiduguri", "Marte", "Mobbar", "Monguno", "Ngala", "Nganzai", "Shani"),
            "Cross River" => array("Akpabuyo", "Odukpani", "Akamkpa", "Biase", "Abi", "Ikom", "Yarkur",
                "Odubra", "Boki", "Ogoja", "Yala", "Obanliku", "Obudu", "Calabar South", "Etung", "Bekwara", "Bakassi", "Calabar Municipality"),
            "Delta" => array("Oshimili", "Aniocha", "Aniocha South", "Ika South", "Ika North-East", "Ndokwa West", "Ndokwa East", "Isoko south", "Isoko North", "Bomadi", "Burutu",
                "Ughelli South", "Ughelli North", "Ethiope West", "Ethiope East", "Sapele", "Okpe", "Warri North", "Warri South", "Uvwie", "Udu", "Warri Central", "Ukwani", "Oshimili North", "Patani"),
            "Ebonyi" =>array("Afikpo South", "Afikpo North", "Onicha", "Ohaozara", "Abakaliki", "Ishielu", "lkwo", "Ezza", "Ezza South", "Ohaukwu", "Ebonyi", "Ivo"),
            "Enugu" =>array("Enugu South,", "Igbo-Eze South", "Enugu North", "Nkanu", "Udi Agwu", "Oji-River", "Ezeagu", "IgboEze North", "Isi-Uzo", "Nsukka", "Igbo-Ekiti", "Uzo-Uwani", "Enugu Eas", "Aninri", "Nkanu East", "Udenu."),
            "Edo" => array("Esan North-East", "Esan Central", "Esan West", "Egor", "Ukpoba", "Central", "Etsako Central", "Igueben", "Oredo", "Ovia SouthWest", "Ovia South-East", "Orhionwon", "Uhunmwonde", "Etsako East", "Esan South-East"),
            "Ekiti" =>array("Ado", "Ekiti-East", "Ekiti-West", "Emure/Ise/Orun", "Ekiti South-West", "Ikere Ekiti", "Irepodun", "Ijero,", "Ido/Osi", "Oye", "Ikole", "Moba", "Gbonyin", "Efon", "Ise/Orun", "Ilejemeje."),
            "FCT"=>array("Abaji", "Abuja Municipal", "Bwari", "Gwagwalada", "Kuje", "Kwali"),
            "Gombe" => array("Akko", "Balanga", "Billiri", "Dukku", "Kaltungo", "Kwami", "Shomgom", "Funakaye", "Gombe", "Nafada/Bajoga", "Yamaltu/Delta."),
            "Imo" =>array("Aboh-Mbaise", "Ahiazu-Mbaise", "Ehime-Mbano", "Ezinihitte", "Ideato North", "Ideato South", "Ihitte/Uboma",
                "Ikeduru", "Isiala Mbano", "Isu", "Mbaitoli", "Mbaitoli", "Ngor-Okpala", "Njaba", "Nwangele", "Nkwerre", "Obowo",
                "Oguta", "Ohaji/Egbema", "Okigwe", "Orlu", "Orsu", "Oru East", "Oru West", "Owerri-Municipal", "Owerri North", "Owerri West"),
            "Jigawa"=>array("Auyo", "Babura", "Birni Kudu", "Biriniwa", "Buji", "Dutse", "Gagarawa", "Garki", "Gumel", "Guri", "Gwaram",
                "Gwiwa", "Hadejia", "Jahun", "Kafin Hausa", "Kaugama Kazaure", "Kiri Kasamma", "Kiyawa", "Maigatari", "Malam Madori",
                "Miga", "Ringim", "Roni", "Sule-Tankarkar", "Taura", "Yankwashi"),
            "Kaduna"=>array("Birni-Gwari", "Chikun", "Giwa", "Igabi", "Ikara", "jaba", "Jema'a", "Kachia", "Kaduna North", "Kaduna South", "Kagarko", "Kajuru", "Kaura", "Kauru", "Kubau", "Kudan", "Lere", "Makarfi", "Sabon-Gari", "Sanga", "Soba", "Zango-Kataf", "Zaria"),
            "Kano"=>array("Ajingi", "Albasu", "Bagwai", "Bebeji", "Bichi", "Bunkure", "Dala", "Dambatta", "Dawakin Kudu", "Dawakin Tofa", "Doguwa", "Fagge", "Gabasawa", "Garko", "Garum", "Mallam", "Gaya", "Gezawa", "Gwale", "Gwarzo", "Kabo", "Kano Municipal", "Karaye", "Kibiya", "Kiru", "kumbotso", "Kunchi", "Kura", "Madobi", "Makoda", "Minjibir",
                "Nasarawa", "Rano", "Rimin Gado", "Rogo", "Shanono", "Sumaila", "Takali", "Tarauni", "Tofa", "Tsanyawa", "Tudun Wada", "Ungogo", "Warawa", "Wudil"),
            "Katsina"=> array("Bakori", "Batagarawa", "Batsari", "Baure", "Bindawa", "Charanchi", "Dandume", "Danja", "Dan Musa", "Daura", "Dutsi", "Dutsin-Ma", "Faskari", "Funtua", "Ingawa", "Jibia", "Kafur", "Kaita", "Kankara", "Kankia", "Katsina", "Kurfi", "Kusada", "Mai'Adua", "Malumfashi", "Mani", "Mashi", "Matazuu", "Musawa", "Rimi", "Sabuwa", "Safana", "Sandamu", "Zango"),
            "Kebbi" =>array("Aleiro", "Arewa-Dandi", "Argungu", "Augie", "Bagudo", "Birnin Kebbi", "Bunza", "Dandi", "Fakai", "Gwandu", "Jega", "Kalgo", "Koko/Besse", "Maiyama", "Ngaski", "Sakaba", "Shanga", "Suru", "Wasagu/Danko", "Yauri", "Zuru"),
            "Kogi"=> array("Adavi", "Ajaokuta","Ankpa", "Bassa", "Dekina", "Ibaji", "Idah", "Igalamela-Odolu", "Ijumu", "Kabba/Bunu", "Kogi", "Lokoja", "Mopa-Muro", "Ofu", "Ogori/Mangongo", "Okehi", "Okene", "Olamabolo", "Omala", "Yagba East", "Yagba West"),
            "Kwara"=> array("Asa","Baruten", "Edu", "Ekiti", "Ifelodun", "Ilorin East", "Ilorin West", "Irepodun", "Isin", "Kaiama", "Moro", "Offa", "Oke-Ero", "Oyun", "Pategi"),
            "Lagos"=> array( "Agege", "Ajeromi-Ifelodun", "Alimosho", "Amuwo-Odofin", "Apapa", "Badagry", "Epe", "Eti-Osa", "Ibeju/Lekki", "Ifako-Ijaye", "Ikeja", "Ikorodu", "Kosofe", "Lagos Island", "Lagos Mainland", "Mushin", "Ojo", "Oshodi-Isolo", "Shomolu", "Surulere"),
            "Nasarawa"=> array("Akwanga", "Awe", "Doma", "Karu", "Keana", "Keffi", "Kokona", "Lafia", "Nasarawa", "Nasarawa-Eggon", "Obi", "Toto", "Wamba"),
            "Niger"=> array("Agaie", "Agwara", "Bida", "Borgu", "Bosso", "Chanchaga", "Edati", "Gbako", "Gurara", "Katcha", "Kontagora", "Lapai", "Lavun",
                "Magama", "Mariga", "Mashegu", "Mokwa", "Muya", "Pailoro", "Rafi", "Rijau", "Shiroro", "Suleja", "Tafa", "Wushishi"),
            "Ogun"=> array("Abeokuta North", "Abeokuta South", "Ado-Odo/Ota", "Egbado North", "Egbado South", "Ewekoro", "Ifo", "Ijebu East", "Ijebu North",
                "Ijebu North East", "Ijebu Ode", "Ikenne", "Imeko-Afon", "Ipokia", "Obafemi-Owode", "Ogun Waterside", "Odeda", "Odogbolu", "Remo North", "Shagamu"),
            "Ondo"=> array( "Akoko North East", "Akoko North West", "Akoko South Akure East", "Akoko South West", "Akure North", "Akure South", "Ese-Odo", "Idanre", "Ifedore", "Ilaje", "Ile-Oluji", "Okeigbo", "Irele",
                "Odigbo", "Okitipupa", "Ondo East", "Ondo West", "Ose", "Owo"),
            "Osun"=> array("Aiyedade", "Aiyedire", "Atakumosa East", "Atakumosa West", "Boluwaduro", "Boripe", "Ede North", "Ede South", "Egbedore", "Ejigbo", "Ife Central", "Ife East",
                "Ife North", "Ife South", "Ifedayo", "Ifelodun", "Ila", "Ilesha East", "Ilesha West", "Irepodun", "Irewole", "Isokan", "Iwo", "Obokun", "Odo-Otin", "Ola-Oluwa", "Olorunda", "Oriade", "Orolu", "Osogbo"),
            "Oyo"=> array("Afijio", "Akinyele", "Atiba", "Atigbo", "Egbeda", "Ibadan Central", "Ibadan North", "Ibadan North West", "Ibadan South East", "Ibadan South West", "Ibarapa Central",
                "Ibarapa East", "Ibarapa North", "Ido", "Irepo", "Iseyin", "Itesiwaju", "Iwajowa", "Kajola", "Lagelu Ogbomosho North",
                "Ogbmosho South", "Ogo Oluwa", "Olorunsogo", "Oluyole", "Ona-Ara", "Orelope", "Ori Ire", "Oyo East", "Oyo West", "Saki East", "Saki West", "Surulere"),
            "Plateau"=> array("Barikin Ladi", "Bassa",
                "Bokkos", "Jos East", "Jos North", "Jos South", "Kanam", "Kanke", "Langtang North", "Langtang South", "Mangu", "Mikang", "Pankshin", "Qua'an Pan", "Riyom", "Shendam", "Wase"),
            "Rivers"=> array("Abua/Odual", "Ahoada East", "Ahoada West", "Akuku Toru", "Andoni", "Asari-Toru", "Bonny", "Degema", "Emohua",
                "Eleme", "Etche", "Gokana", "Ikwerre", "Khana", "Obia/Akpor", "Ogba/Egbema/Ndoni", "Ogu/Bolo", "Okrika", "Omumma", "Opobo/Nkoro", "Oyigbo", "Port-Harcourt", "Tai"),
            "Sokoto"=> array("Binji","Bodinga","Dange-shnsi", "Gada", "Goronyo", "Gudu", "Gawabawa", "Illela", "Isa", "Kware", "kebbe", "Rabah", "Sabon birni", "Shagari", "Silame", "Sokoto North", "Sokoto South",
                "Tambuwal","Tqngaza", "Tureta", "Wamako", "Wurno", "Yabo"),
            "Taraba"=> array("Ardo-kola","Bali", "Donga", "Gashaka", "Cassol", "Ibi", "Jalingo", "Karin-Lamido", "Kurmi", "Lau", "Sardauna", "Takum", "Ussa", "Wukari", "Yorro", "Zing"),
            "Yobe"=> array( "Bade", "Bursari", "Damaturu", "Fika", "Fune", "Geidam", "Gujba", "Gulani", "Jakusko",
                "Karasuwa", "Karawa", "Machina", "Nangere", "Nguru Potiskum", "Tarmua", "Yunusari", "Yusufari"),
            "Zamfara"=> array("Anka","Bakura", "Birnin Magaji", "Bukkuyum", "Bungudu", "Gummi", "Gusau", "Kaura", "Namoda", "Maradun", "Maru", "Shinkafi", "Talata Mafara", "Tsafe", "Zurmi"),
        );

        // Display lga dropdown based on state name
        if($request->state !== ''){
            echo "<option disabled selected>--Select Lga--</option>";
            foreach($stateArr[$request->state] as $lga){
                echo "<option>". $lga . "</option>";
            }
        }

    }
}
