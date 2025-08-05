<div class="dark:text-gray-200 p-4">
  <div class="flex flex-col gap-4 rounded-xl border border-neutral-200 dark:border-neutral-700 p-4">


   <div class="flex justify-between w-full">
        <div>
            <h3  class="text-xl font-semibold mb-2">{{ $invoice->company->name }}</h3>
            <div>{{ $company->address }}</div>
            <div>{{ $company->city }}, {{ $company->state }}</div>
            <div>Mobile : {{ $company->phone }}</div>
             <div>GSTIN : {{ $company->gstin }}</div>
        </div>
        <div><img src="https://picsum.dev/480" class="w-30 rounded-4xl"/></div>
        <div>
             <h3 class="text-xl font-semibold mb-2">Invoice # {{ $invoice->invoice_number }}</h3>
             <div>Date : {{ $invoice->invoice_date }}</div>
              <div>Email : {{ $company->email }}</div>
              <div>Website : {{ $company->website }}</div>
        </div>
    </div>
    <div><strong><span class="px-2 py-1 bg-blue-400">BILL TO </span></strong> </div>
   <div class="flex justify-between">
    <div> <div><b> {{ $invoice->billing_name }}</b></div>
    <div>{{ $invoice->billing_address }}</div>
     <div>Mobile : {{ $invoice->billing_mobile}}</div>
    <div>GSTIN : {{ $invoice->billing_gstin }}</div>
 <div>Email : {{ $invoice->billing_email }}</div>
   </div>
   <div class="my-auto"> <div>Order No : {{ $invoice->order_number }}</div>
   <div> Order Date : {{ $invoice->order_date }}</div>
   </div>
</div>
 

    <!-- Responsive wrapper for horizontal scroll on small screens -->
    <div class="overflow-x-auto border border-gray-300 dark:border-gray-700 rounded-md">
      <table class="min-w-full border-collapse font-sans text-sm print:min-w-full print:border print:border-black print:bg-white print:text-black">
        <thead>
          <tr class="bg-blue-900 text-white print:bg-black print:text-white">
            <th class="border border-gray-300 dark:border-gray-700 px-3 py-2 w-1/20 text-center">#</th>
            <th class="border border-gray-300 dark:border-gray-700 px-3 py-2 w-3/20 text-left">Item Name</th>
            <th class="border border-gray-300 dark:border-gray-700 px-3 py-2 w-7/20 text-left">Description</th>
             <th class="border border-gray-300 dark:border-gray-700 px-3 py-2 w-1/20 text-left">HSN</th>
             <th class="border border-gray-300 dark:border-gray-700 px-3 py-2 w-1/20 text-left">Quantity</th>
            <th class="border border-gray-300 dark:border-gray-700 px-3 py-2 w-2/20 text-right">Rate</th>
            <th class="border border-gray-300 dark:border-gray-700 px-3 py-2 w-2/20 text-right">Total</th>
          </tr>
        </thead>
        <tbody>
          @foreach($invoice->items as $index => $item)
            <tr class="{{ $index % 2 == 0 ? 'bg-gray-50 dark:bg-gray-800 print:bg-white' : 'bg-white dark:bg-gray-900 print:bg-white' }} text-center dark:text-gray-200">
              <td class="border border-gray-300 dark:border-gray-700 px-3 py-1 text-center">{{ $index + 1 }}</td>
              <td class="border border-gray-300 dark:border-gray-700 px-3 py-1 text-left">{{ $item->item_name }}</td>
              <td class="border border-gray-300 dark:border-gray-700 px-3 py-1 text-left">
                Fill in the details below to create a new company profile. 
              </td>
               <td class="border border-gray-300 dark:border-gray-700 px-3 py-1 text-center">{{ '4202' }}</td>
               <td class="border border-gray-300 dark:border-gray-700 px-3 py-1 text-center">{{ $item->quantity }}</td>
              <td class="border border-gray-300 dark:border-gray-700 px-3 py-1 text-right">{{ number_format($item->rate, 2) }}</td>
              <td class="border border-gray-300 dark:border-gray-700 px-3 py-1 text-right">{{ number_format($item->total, 2) }}</td>
            </tr>
          @endforeach
        </tbody>
        <tfoot>
          <tr class="bg-gray-100 dark:bg-gray-700 font-semibold text-right dark:text-gray-200 print:bg-gray-200">
            <td colspan="6" class="border border-gray-300 dark:border-gray-700 px-3 py-2 text-right">Subtotal:</td>
            <td colspan="1" class="border border-gray-300 dark:border-gray-700 px-3 py-2">{{ number_format($invoice->subtotal, 2) }}</td>
          </tr>
          <tr class="bg-gray-100 dark:bg-gray-700 font-semibold text-right dark:text-gray-200 print:bg-gray-200">
            <td colspan="6" class="border border-gray-300 dark:border-gray-700 px-3 py-2 text-right">{{ $invoice->tax_type }} @ {{ $invoice->tax_rate }} %</td>
            <td colspan="1" class="border border-gray-300 dark:border-gray-700 px-3 py-2">{{ number_format($invoice->tax_amount, 2) }}</td>
          </tr>
          <tr class="bg-gray-200 dark:bg-gray-600 font-bold text-right dark:text-gray-100 print:bg-gray-300">
            <td colspan="6" class="border border-gray-300 dark:border-gray-700 px-3 py-3 text-right">Grand Total:</td>
            <td colspan="1" class="border border-gray-300 dark:border-gray-700 px-3 py-3">{{ number_format($invoice->grand_total, 2) }}</td>
          </tr>
          <tr class="bg-yellow-50 dark:bg-yellow-900 text-center dark:text-yellow-300 font-semibold print:bg-yellow-100">
            <td colspan="7" class="border border-gray-300 dark:border-gray-700 px-3 py-3">
              Total (in words): {{ App\Helpers\NumberToWordsHelper::convertNumberToWordsINR($invoice->grand_total) }}
            </td>
          </tr>
        </tfoot>
      </table>

     
    </div>
 <p>
        <b>Terms & Conditions:</b>
<ul class="list-decimal pl-6 space-y-1 text-sm text-justify">
  <li>
    Upon completion of the Project, the Client shall make full
    payment of the fees to the Developer upon which the Developer
    shall make live or deploy the completed Website to the Client’s hosting server.
  </li>

  <li>
   If the Client requires the completed Website to be loaded
    onto third-party hosting services provided by the client,
    the Developer reserves the right to charge additional fees to the Client for this service.
    The Client is responsible for ensuring that the intended file server or disk space is properly configured.
  </li>

  <li>
 Something else.
  </li>
</ul>
        {{ $invoice->override_terms_and_conditions }} 
      </p>
  </div>
</div>
