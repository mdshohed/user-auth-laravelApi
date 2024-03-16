<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6 center-screen">
            <div class="card animated fadeIn w-90  p-4">
                <div class="card-body">
                    <h4>ENTER OTP CODE</h4>
                    <br/>
                    <label>5 Digit Code Here</label>
                    <input id="otp" placeholder="Code" class="form-control" type="text"/>
                    <br/>
                    <button onclick="VerifyOtp()"  class="btn w-100 float-end bg-gradient-primary">Next</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
   async function VerifyOtp() {
        let otp = document.getElementById('otp').value;
        if(otp.length !== 5){
           errorToast('Invalid OTP')
        }
        else{
            // let res=await axios.post('/verify-otp', {
            //     otp: otp,
            //     email:sessionStorage.getItem('email')
            // })

            // if(res.status===200 && res.data['status']==='success'){
            //     sessionStorage.clear();
            //     setTimeout(() => {
            //         window.location.href='/resetPassword'
            //     }, 1000);
            // }
            // else{
            //     errorToast(res.data['message'])
            // }
            const data = {
                otp: otp,
                email:sessionStorage.getItem('email')
            }
            console.log(data);

            await axios.post('/verify-otp', data)
            .then((res)=>{
                console.log(res);
                if(res.status===200 && res.data['status']==='success'){
                console.log(res.data['message'])
                sessionStorage.clear();
                setTimeout(function (){
                    window.location.href = '/resetPassword';
                }, 1000)
            }
            })
            .catch((error)=>{
                console.log(error);
            })
        }
    }
</script>
