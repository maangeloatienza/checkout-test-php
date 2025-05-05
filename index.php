<?php 
    if (!isset($_SESSION)) {
        session_start();
    } else {
        echo "Session already started <br>";
        var_dump($_SESSION);
        session_destroy();
        session_start();
    }
    include('includes/header.php');

    function cardType($card_type) {
        switch ($card_type) {
            case 1:
                return 'Visa';
            case 2:
                return 'MasterCard';
            case 3:
                return 'American Express';
            default:
                return 'Unknown Card Type';
        }
    }
?>
<div class="bg-black h-full w-full"  >

    <div class="shadow-lg bg-white h-full min-h-screen max-w-full sm:w-[var(--screen-sm)] md:w-[var(--screen-md)] lg:w-[var(--screen-lg)]  w-[var(--screen-xl)] mx-auto px-4 lg:px-20 py-5 flex flex-col gap-4 justify-center md:justify-start" >
        <h1 class="text-4xl" id="checkout-header">Checkout Page</h1>

        <section class="sections flex flex-col gap-4 h-full justify-center" id="customer-details" data-step="1" data-show-page="yes">
            <h3 class="text-2xl pt-3">Customer Details</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="flex flex-col">
                    <label for="first_name" class="text-sm">First <span class="text-red-500">*</span></label>
                    <input type="text" name="first_name" id="" placeholder="First name" class="customer-fields h-12 md:h-14 border-2 border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:border-[var(--primary-color)]" data-input-value="first_name" required >
                </div>
                <div class="flex flex-col">
                    <label for="last_name" class="text-sm">Last name <span class="text-red-500">*</span></label>
                    <input type="text" name="last_name" id="last_name" placeholder="Last name" class="customer-fields h-12 md:h-14 border-2 border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:border-[var(--primary-color)]" data-input-value="last_name" required>
                </div>
            </div>

            <div class="flex flex-col">
                <label for="email" class="text-sm">Email <span class="text-red-500">*</span></label>
                <input type="email" name="email" id="email" placeholder="Email address" class="customer-fields h-12 md:h-14 border-2 border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:border-[var(--primary-color)]" data-input-value="email" required>
            </div>

            <div class="flex flex-col">
                <label for="address" class="text-sm">Address <span class="text-red-500">*</span></label>
                <input type="text" name="address" id="address" placeholder="Address" class="customer-fields h-12 md:h-14 border-2 border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:border-[var(--primary-color)]" data-input-value="address" required>
            </div>
            

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="flex flex-col">
                    <label for="city" class="text-sm">City <span class="text-red-500">*</span></label>
                    <input type="text" name="city" id="city" placeholder="City" class="customer-fields h-12 md:h-14 border-2 border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:border-[var(--primary-color)]" data-input-value="city" required >
                </div>

                <div class="flex flex-col">
                    <label for="state" class="text-sm">State <span class="text-red-500">*</span></label>
                    <input type="text" name="state" id="state" placeholder="State" class="customer-fields h-12 md:h-14 border-2 border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:border-[var(--primary-color)]" data-input-value="state" required >
                </div>
            </div>

            <div class="flex flex-col">
                <label for="phone" class="text-sm">Phone number <span class="text-red-500">*</span></label>
                <input type="number" name="phone" id="phone" placeholder="Phone number" class="customer-fields h-12 md:h-14 border-2 border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:border-[var(--primary-color)]" data-input-value="phone" required>
            </div>
            <p class="hidden text-sm text-center text-white bg-red-500" id="customer-error-message"></p>
            <div class="mt-auto h-auto flex justify-center items-center md:justify-end md:items-end">
                <button class="text-white text-lg bg-[var(--primary-color)] border-2 border-transparent hover:border-[var(--primary-color)] hover:bg-transparent hover:text-[var(--primary-color)]  px-4 py-2 rounded-full cursor-pointer" id="customer-details-button">Proceed to payment</button>
            </div>

        </section>

        <section class="sections flex md:flex-col gap-4 max-h-screen justify-start" id="customer-payment" data-step="2" data-show-page="no">

            
            <div class="flex flex-col gap-4">
            <h2 class="text-2xl pt-4">Payment Details</h2>
                <div class="flex flex-col">
                    <label for="card_type" class="text-sm">Card type <span class="text-red-500">*</span></label>
                    <select name="card_type" id="card_type" class="payment-fields h-12 md:h-14 border-2 border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:border-[var(--primary-color)]" data-input-value="card_type" required>
                        <option value="">Select card type</option>
                        <option value="1">Visa</option>
                        <option value="2">MasterCard</option>
                        <option value="3">American Express</option>
                    </select>
                </div>
                <div class="border-2 border-gray-300 rounded-md p-8 flex flex-col gap-4">
                    <div class="flex gap-4">
                        <div class="flex flex-col w-8/10">
                            <label for="first_name_card" class="text-sm">Name on card</label>
                            <input type="text" name="name_on_card" id="name_on_card" placeholder="Name on card" class="cursor-not-allowed h-8 md:h-10 border-t-0 border-s-0 border-e-0 border-b-2 border-gray-300  px-4 py-2 focus:outline-none focus:border-[var(--primary-color)]" data-input-value="first_name" value="<?=$_SESSION["customer"]["first_name"] . " " . $_SESSION["customer"]["last_name"] ?>" disabled>
                        </div>
                        <div class="w-2/10 flex justify-center items-center">
                            <img src="https://placehold.co/600x400?text=Card" alt="" id="card-logo" class="h-20 object-contain">
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        
                        <div class="flex flex-col">
                            <label for="card_number" class="text-sm">Card number <span class="text-red-500">*</span></label>
                            <input type="text" name="card_number" id="card_number" placeholder="****-****-****" class="payment-fields h-8 md:h-10 border-t-0 border-s-0 border-e-0 border-b-2 border-gray-300  px-4 py-2 focus:outline-none focus:border-[var(--primary-color)]" data-input-value="card_number" required>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="flex flex-col">
                                <label for="card_exp_date" class="text-sm">Card Expiration Date <span class="text-red-500">*</span></label>
                                <input type="month" name="card_exp_date" id="card_exp_date" placeholder="mm/yyyy" class="payment-fields h-8 md:h-10 border-t-0 border-s-0 border-e-0 border-b-2 border-gray-300  px-4 py-2 focus:outline-none focus:border-[var(--primary-color)]" data-input-value="card_exp_date" required>
                            </div>
                            <div class="flex flex-col">
                                <label for="card_cvv" class="text-sm">Card number <span class="text-red-500">*</span></label>
                                <input type="number" name="card_cvv" id="card_cvv" placeholder="***" class="payment-fields h-8 md:h-10 border-t-0 border-s-0 border-e-0 border-b-2 border-gray-300  px-4 py-2 focus:outline-none focus:border-[var(--primary-color)]" data-input-value="card_cvv" required>
                            </div>
                        </div>

                    </div>
            
                </div>
                <p class="hidden text-sm text-center text-white bg-red-500" id="payment-error-message"></p>
                <div class="mt-auto h-auto md:h-[100px] flex justify-center items-center md:justify-end md:items-end">
                    <button class="text-white text-lg bg-[var(--primary-color)] border-2 border-transparent hover:border-[var(--primary-color)] hover:bg-transparent hover:text-[var(--primary-color)]  px-4 py-2 rounded-full cursor-pointer" data-next-page="payment-details-button" id="payment-details-button">Place order</button>
                </div>
            </div>

        </section>

        <section  class="sections flex md:flex-col gap-4 w-full max-w-screen max-h-screen justify-center" id="customer-summary" data-step="3" data-show-page="no">
            <div class="flex flex-col gap-4 border-2 border-gray-100 justify-center items-center py-4 w-full">
                <h2 class="text-2xl">Summary</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 w-full md:w-full  gap-8 md:gap-4">
                    <div class="flex flex-col items-center gap-4">
                        <h3 class="text-xl">Customer Details</h3>
                        <div class="flex flex-col gap-3" id="customer-details-summary">
                        
                        </div>
                    </div>
                    <div class="flex flex-col items-center gap-4">
                        <h4 class="text-lg">Payment Details</h4>
                        <div class="flex flex-col gap-3" id="payment-details-summary">
                          
                        </div>
                    </div>
            </div>
            <div>
                <button class="text-white text-lg bg-[var(--primary-color)] border-2 border-transparent hover:border-[var(--primary-color)] hover:bg-transparent hover:text-[var(--primary-color)]  px-4 py-2 rounded-full cursor-pointer" data-next-page="payment-details-button" id="payment-confirm-button">Confirm</button>
            </div>
        </section>

        <section  class="sections flex gap-4 h-full  w-full max-w-screen max-h-screen justify-center items-center" id="customer-summary" data-step="4" data-show-page="no">

            <div class="flex flex-col gap-4 border-2 border-gray-100 justify-center items-center py-4 w-full h-full">
                <h2 class="text-2xl text-center">Payment Confirmed!</h2>

                <h3 class="text-xl">Thank you for your payment!</h3>
                <div>
                    <button class="text-white text-lg bg-[var(--primary-color)] border-2 border-transparent hover:border-[var(--primary-color)] hover:bg-transparent hover:text-[var(--primary-color)]  px-4 py-2 rounded-full cursor-pointer" data-next-page="go-back-button" id="go-back-button">Go back</button>
                </div>
            </div>

        </section>
    </div>

</div>
<?php 
    include('includes/footer.php');


?>