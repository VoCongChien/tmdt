<?php

namespace App\Http\Controllers;

use App\Slide;
use App\Product;
use App\ProductType;
use App\Cart;
use App\Customer;
use App\Bill;
use App\BillDetail;
use App\User;
use Hash;
use Auth;
use Session;

use Illuminate\Http\Request;


class PageController extends Controller
{
    public function getIndex(){
        $slide = Slide::all();
        $new_product = Product::where('new',1)->paginate(4);
        $sanpham_khuyenmai = Product::where('promotion_price','<>',0)->paginate(8);
    	return view('page.trangchu',compact('slide','new_product','sanpham_khuyenmai'));
    }

    public function postSapXep(Request $req){
        $slide = Slide::all();
        $sapxep = Product::orderBy('unit_price')->get();
        $sapxepgiam = Product::orderBy('unit_price','desc')->get();
        if($req->sx=='1')
            return view('page.sapxep',compact('slide','sapxep'));
        else
            return view('page.sapxepgiam',compact('slide','sapxepgiam'));
    }

    public function getLoaiSp($type){
        $sp_theoloai = Product::where('id_type',$type)->get();
        $sp_khac = Product::where('id_type','<>',$type)->paginate(3);
        $loai = ProductType::all();
        $loai_sp = ProductType::where('id',$type)->first();
    	return view('page.loai_sanpham',compact('sp_theoloai','sp_khac','loai','loai_sp'));
    }

    public function getChiTiet($idsp){
        $sanpham = Product::where('id',$idsp)->first();
        $sp_tuongtu = Product::where('id_type',$sanpham->id_type)->paginate(6);
    	return view('page.chitiet_sanpham',compact('sanpham','sp_tuongtu'));
    }

    public function getLienHe(){
    	return view('page.lienhe');
    }

    public function getGioiThieu(){
    	return view('page.gioithieu');
    }

    public function postAddtoCart(Request $req,$id){
        $product = Product::find($id);
        $oldCart = Session('cart')?Session::get('cart'):null;
        $cart = new Cart($oldCart);
        $cart->add($product,$id,$req->sl);
        $req->session()->put('cart',$cart);
        return redirect()->back();
    }

    public function getDelItemCart($id){
        $oldCart = Session::has('cart')?Session::get('cart'):null;
        $cart = new Cart($oldCart);
        $cart ->removeItem($id);
        if(count($cart->items)>0){
            Session::put('cart',$cart);
        }
        else{
            Session::forget('cart');
        }
        return redirect()->back();
    }

    public function getDatHang(){
        return view('page.dat_hang');
    }

    public function postDatHang(Request $req){
        $cart = Session::get('cart');
        
        $customer = new Customer;
        $customer->name = $req->name;
        $customer->gender = $req->gioitinh;
        $customer->email = $req->email;
        $customer->address =$req->adress;
        $customer->phone_number = $req->phone;
        $customer->note = $req->notes;
        $customer->save();

        $bill = new Bill;
        $bill->id_customer = $customer->id;
        $bill->date_order = date('Y-m-d');
        $bill->total = $cart->totalPrice;
        $bill->payment = $req->payment_method;
        $bill->note = $req->notes;
        $bill->save();

        foreach ($cart->items as $key => $value) {
            $bill_detail = new BillDetail;
            $bill_detail->id_bill = $bill->id;
            $bill_detail->id_product = $key;
            $bill_detail->quantity= $value['qty'];
            $bill_detail->unit_price = ($value['price']/$value['qty']); 
            $bill_detail->save();

       } 
       Session::forget('cart');
       return redirect()->back()->with('thong bao','Đặt hàng thành công!');

    }

    public function getLogin(){
        return view('page.dangnhap');
    }

    public function getRegister(){
        return view('page.dangky');
    }

    public function postRegister(Request $req){
        $this->validate($req,
            [
                'email'=> 'required|email|unique:users,email',
                'password'=> 'required|min:6|max:20',
                'fullname'=> 'required',
                're_password'=> 'required|same:password'
            ],
            [
                'email.required'=>'Vui lòng nhập email',
                'email.email'=>'Không đúng định dạng email',
                'email.unique'=>'Email đã có người sử dụng',
                'password.required'=>'Vui lòng nhập mật khẩu',
                're_password.same'=>'Mật khẩu không giống nhau',
                'password.min'=>'Mật khẩu ít nhất 6 kí tự'
            ]);
        $user = new User;
        $user->full_name = $req->fullname;
        $user->email = $req->email;
        $user->password = Hash::make($req->password);
        $user->phone = $req->phone;
        $user->address = $req->address;
        $user->save();
        return redirect()->back()->with('thanhcong','Đã tạo tài khoản thành công!');
    }

    public function postLogin(Request $req){
        $this->validate($req,
            [
                'email'=>'required|email',
                'password'=>'required|min:6|max:20'
            ],
            [
                'email.required'=>'Vui lòng nhập email!',
                'email.email'=>'Email không đúng định dạng',
                'password.required'=>'Vui lòng nhập mật khẩu',
                'password.min'=>'Mật khẩu ít nhất 6 kí tự',
                'password.max'=>'Mật khẩu nhiều nhất 20 kí tự'   
            ]);
            $chungthuc = array('email' =>$req->email,'password'=>$req->password);
            if(Auth::attempt($chungthuc)){
                return redirect()->route('trangchu');
            }
            else{
                return redirect()->back()->with(['flag'=>'danger','thongbao'=>'Đăng nhập không thành công!']);
            }
        
    }

    public function postLogout(){
        Auth::logout();
        Session::forget('cart');
        return  redirect()->route('trangchu');
    }

    public function getTimKiem(Request $req){
        $product = Product::where('name','like','%'.$req->key.'%')->orwhere('unit_price',$req->key)->get();
        return view('page.search',compact('product'));

    }
}
