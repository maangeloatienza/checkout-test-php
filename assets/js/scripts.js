

(async function(){
    console.log('Script loaded');

    const sections = document.querySelectorAll('.sections');
    const customerDataFields = document.querySelectorAll('.customer-fields');
    const paymentDataFields = document.querySelectorAll('.payment-fields');
    const paymentOptions = document.getElementById('card_type');
    const customerDetailsBtn = document.getElementById('customer-details-button');
    const paymentDetailsBtn = document.getElementById('payment-details-button');
    const paymentConfirmBtn = document.getElementById('payment-confirm-button');
    const goBackBtn = document.getElementById('go-back-button');
    const checkoutHeader = document.getElementById('checkout-header');
    let customerAllFilled = true;
    let paymentAllFilled = true;
    let customerDetails = {};
    let paymentDetails = {};
    let step = 1;

    const cardLogo = {
        '1': 'https://corporate.visa.com/content/dam/VCOM/corporate/about-visa/images/visa-brandmark-blue-1960x622.png',
        '2': 'https://www.mastercard.com/content/dam/public/brandcenter/en/Logo-1.5x.png',
        '3': 'https://zincstorestorage.blob.core.windows.net/amex/Assets/1093/1424?t=20231211133022',

    }
    
    const render = () => {
        
        const loadCheckoutPage = () => {

            sections.forEach(section => {
                let currentStep = section.dataset.step;
                let currentShowPage = section.dataset.showPage;
                console.log('Current step: ', currentStep, 'Current show page: ', currentShowPage)
                if (currentStep == step) {
                    section.classList.remove('hidden');
                    currentShowPage = "yes"
                    if(step == 4) {
                        console.log("STEP 4")
                        checkoutHeader.classList.add('hidden');
                    }else {
                        checkoutHeader.classList.remove('hidden')

                    }
                } else {
                    section.classList.add('hidden');
                    currentShowPage = "no"
                }
                
                
            })
            
        }

        const showErrorMessage = (element, message) => {
            element.textContent = message;
            element.classList.toggle('hidden');

            setTimeout(() => {
                element.classList.toggle('hidden');
                element.textContent = '';
                customerAllFilled = true;
                paymentAllFilled = true;
            },3000)
        }

        paymentOptions.addEventListener('change', function(e) {
            const cardType = e.target.value;
            const cardLogoElement = document.getElementById('card-logo');
            cardLogoElement.src = cardLogo[cardType];
            
            

        })

        const customerDetailsSession = async () => {
            console.log('Customer details session loaded');
            const getCustomerSession = await fetch('./functions/customer-session.php')
            const response = await getCustomerSession.json()
    
            customerDetails = response.data

            // map the customer details to the fields

            const nameOnCard = document.getElementById('name_on_card').value = customerDetails?.first_name + ' ' + customerDetails?.last_name;

            const customerSummary = document.getElementById('customer-details-summary');

            customerSummary.innerHTML = `
                <p>First Name: ${customerDetails?.first_name}</p>
                <p>Last Name: ${customerDetails?.last_name}</p>
                <p>Email: ${customerDetails?.email}</p>
                <p>Phone: ${customerDetails?.phone}</p>
                <p>Address: ${customerDetails?.address}</p>
                <p>City: ${customerDetails?.city}</p>
                <p>State: ${customerDetails?.state}</p>
                `
        }

        const customerPaymentSession = async () => {
            console.log('Customer Payment session loaded');
            const getPaymentSession = await fetch('./functions/customer-payment-session.php')
            const response = await getPaymentSession.json()
    
            paymentDetails = response.data

            const paymentSummary = document.getElementById('payment-details-summary');

            paymentSummary.innerHTML = `
                <p>Card Type: ${paymentDetails?.card_type}</p>
                <p>Card Number: ${paymentDetails?.card_number}</p>
                <p>Card Expiration Date: ${paymentDetails?.card_exp_date}</p>
            `
        }

        goBackBtn.addEventListener('click', function(e) {
            e.preventDefault();
            step=1
            loadCheckoutPage();
        })

        customerDetailsBtn.addEventListener('click',async function(e) {
            e.preventDefault();

            const body = new Map()
            for(const item of Object.keys(customerDataFields)){

                if (!customerDataFields[item].value.trim()) {
                    customerAllFilled = false;
                    console.log('Field not filled: ', customerDataFields[item]);
                    break;
                }
                let field = customerDataFields[item].dataset.inputValue;
                let value = customerDataFields[item].value;

                body.set(field, value);

            };

            if(!customerAllFilled) {
                // error message
                showErrorMessage(document.getElementById('customer-error-message'), 'Please fill all fields');
                return
            }

            const requestBody = Object.fromEntries(body)
    
            const request = await fetch('./functions/customer-session.php',{
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(requestBody)
            })
            console.log(request)
    
            if (request.ok) {
                step+=1;
                loadCheckoutPage();
                customerDetailsSession();
                
            } else {
                console.log('Error: ', request.message);
            }
        })

        paymentDetailsBtn.addEventListener('click',async function(e) {
            e.preventDefault();
            const body = new Map()
            for(const item of Object.keys(paymentDataFields)){

                let field = paymentDataFields[item].dataset.inputValue;
                let value = paymentDataFields[item].value;
                console.log('Field: ', field, 'Value: ', value)
                if (!paymentDataFields[item].value.trim()) {
                    paymentAllFilled = false;
                    console.log('Field not filled: ', paymentDataFields[item]);
                    break;
                }
                body.set(field, value);

            };
            console.log('Body: ', body)
            if(!paymentAllFilled) {
                // error message
                showErrorMessage(document.getElementById('payment-error-message'), 'Please fill all fields');
                return
            }

            const requestBody = Object.fromEntries(body)
    
            const request = await fetch('./functions/customer-payment-session.php',{
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(requestBody)
            })
            console.log(request)
    
            if (request.ok) {
                step+=1;
                loadCheckoutPage();
                customerPaymentSession();
            } else {
                console.log('Error: ', request.message);
            }
        });

        paymentConfirmBtn.addEventListener('click',async function(e) {
            e.preventDefault();
            
            const body = new Map()

            body.set('customer', customerDetails);
            body.set('payment', paymentDetails);

            const requestBody = Object.fromEntries(body)
            const saveData = await fetch('./functions/save-customer-payment-details.php',{
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(requestBody)
            })

            const response = await saveData.json()
            console.log('Save data: ', response)

            if(response.status == 'success') {
                step+=1;
                loadCheckoutPage();
            }
        })

        loadCheckoutPage();
    }


    render();
})()