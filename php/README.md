                                             CEDIPLUS PHP API DOCUMENTATION
CediPlus API is designed to send bill or check bill, this documentation is targeted for the use by programmers and hence would be much appreciated by programmers. Thank you for choosing CediPlus.

PHASES
1. POST REQUEST(SEND BILL)
2. GET REQUEST(CHECK BILL)

                                                POST BILL(SEND BILL)
IMPLEMENTATION

| Parameters | Values | Description |
| --- | --- | --- |
| action `required`| sendbill | This is to indicate transaction type whether to send bill or check bill |                               
| wallet_type `required` | m,t | This is to indicate the wallet type to use for the transaction Where ‘m’ is for mtn and ‘t’ is for tigo wallets respectively |  
| wallet `required` | 000 000 0000 | This is the phone number for the transaction |
| amount `required` | 1.00 | Amount of money (max of 999,999.00 cedis). |
| api_key `required` | xxxxxxxxxxxxxxxxxxxxxx | This is your Business or Demo API key |
| description `required` | testing | This is to give a description of the transaction. | 


                    
