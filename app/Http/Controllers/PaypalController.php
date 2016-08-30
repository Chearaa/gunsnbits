<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Paypal;
use App\Paypalitem;
use Laracasts\Flash\Flash;
use Session;
use Illuminate\Http\Request;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\ExecutePayment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;
use PayPal\Exception\PayPalConnectionException;

class PaypalController extends Controller {

    private $_api_context;

    /**
     * PaypalController constructor.
     */
    public function __construct() {
        $this->middleware('auth');

        // setup PayPal api context
        $paypal_conf = config('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_conf['client_id'], $paypal_conf['secret']));
        $this->_api_context->setConfig($paypal_conf['settings']);
    }

    /**
     * Postpayment
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postPayment() {

        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $item_1 = new Item();
        $item_1->setName('GNB63-42-1') // item name
        ->setCurrency('EUR')
            ->setQuantity(1)
            ->setPrice('0.01'); // unit price

        $item_2 = new Item();
        $item_2->setName('GNB63-42-2') // item name
        ->setCurrency('EUR')
            ->setQuantity(1)
            ->setPrice('0.01'); // unit price

        // add item to list
        $item_list = new ItemList();
        $item_list->setItems([$item_1, $item_2]);

        $amount = new Amount();
        $amount->setCurrency('EUR')
            ->setTotal(0.02);

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($item_list)
            ->setDescription('Your transaction description');

        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(route('paypal.payment.status'))
            ->setCancelUrl(route('paypal.payment.status'));

        $payment = new Payment();
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirect_urls)
            ->setTransactions(array($transaction));

        try {
            $payment->create($this->_api_context);
        } catch (PayPalConnectionException $ex) {
            if (\config('app.debug')) {
                echo "Exception: " . $ex->getMessage() . PHP_EOL;
                $err_data = json_decode($ex->getData(), true);
                dump($err_data);
                exit;
            } else {
                Flash::error('Something went wrong, Sorry for inconvenience');
                return redirect('/');
            }
        }

        foreach($payment->getLinks() as $link) {
            if($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }

        // add payment ID to session
        Session::put('paypal_payment_id', $payment->getId());

        if(isset($redirect_url)) {
        // redirect to paypal
            return redirect($redirect_url);
        }
        Flash::error('Unknown error occurred');
        return redirect('/');
    }

    /**
     * getPaymentStatus
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function getPaymentStatus(Request $request)
    {
        // Get the payment ID before session clear
        $payment_id = Session::get('paypal_payment_id');

        // clear the session payment ID
        Session::forget('paypal_payment_id');

        if (empty($request->input('PayerID')) || empty($request->input('token'))) {
            Flash::error('Payment Failed');
            return redirect('/');
        }

        $payment = Payment::get($payment_id, $this->_api_context);

        // PaymentExecution object includes information necessary
        // to execute a PayPal account payment.
        // The payer_id is added to the request query parameters
        // when the user is redirected from paypal back to your site
        $execution = new PaymentExecution();
        $execution->setPayerId($request->input('PayerID'));

        //Execute the payment
        $result = $payment->execute($execution, $this->_api_context);

        /*
        * Get the ID with : $result->id
        * Get the State with $result->state
        * Get the Payer State with $result->payer->payment_method
        * Get The Shipping Address and More Detail like below :- $result->payer->payer_info->shipping_address
        * Get More detail about shipping address like city country name
        */

        //echo '<pre>';print_r($result);echo '</pre>';exit; // DEBUG RESULT.

        if ($result->getState() == 'approved') { // payment made

            //save payment in database
            $paypal = new Paypal([
                'paypal_id' => $result->id,
                'intent' => $result->intent,
                'state' => $result->state,
                'cart' => $result->cart,
                'payer_status' => $result->payer->status,
                'payer_email' => $result->payer->payer_info->email,
                'payer_first_name' => $result->payer->payer_info->first_name,
                'payer_last_name' => $result->payer->payer_info->last_name,
                'payer_id' => $result->payer->payer_info->payer_id,
                'transaction_amount_total' => $result->transactions[0]->amount->total,
                'transaction_amount_currency' => $result->transactions[0]->amount->currency,
                'transaction_description' => $result->transactions[0]->description
            ]);
            Auth::user()->paypals()->save($paypal);

            foreach($result->transactions[0]->item_list->items as $item) {
                $paypalitem = new Paypalitem([
                    'name' => $item->name,
                    'price' => $item->price,
                    'currency' => $item->currency,
                    'quantity' => $item->quantity
                ]);

                $paypal->paypalitems()->save($paypalitem);
            }
            $paypal->save();

            Flash::success('Paypal-Überweisung erfolgreich!');
            return redirect(route('home'));
        }
        Flash::error('Paypal-Überweisung nicht erfolgreich abgeschlossen');
        return redirect(route('home'));
    }

}