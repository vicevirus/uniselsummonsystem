import 'package:flutter/material.dart';
import 'package:qr_code_scanner/qr_code_scanner.dart';
import 'package:http/http.dart' as http;
import 'package:shared_preferences/shared_preferences.dart';
import 'package:fluttertoast/fluttertoast.dart';

class QRViewExample extends StatefulWidget {
  @override
  State<StatefulWidget> createState() => _QRViewExampleState();
}

class _QRViewExampleState extends State<QRViewExample> {
  final GlobalKey qrKey = GlobalKey(debugLabel: 'QR');
  Barcode? result;
  QRViewController? controller;
  TextEditingController violationController = TextEditingController();
  TextEditingController fineAmountController = TextEditingController();
  String dueDate = '';

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text('QR Code Summon Scanner'),
        centerTitle: true,
      ),
      body: SingleChildScrollView(
        child: Column(
          children: <Widget>[
            Padding(
              padding: const EdgeInsets.all(8.0),
              child: AspectRatio(
                aspectRatio: 16 / 9,
                child: Container(
                  decoration: BoxDecoration(
                    border: Border.all(color: Colors.blueAccent),
                    borderRadius: BorderRadius.circular(12),
                  ),
                  child: QRView(
                    key: qrKey,
                    onQRViewCreated: _onQRViewCreated,
                  ),
                ),
              ),
            ),
            Padding(
              padding: const EdgeInsets.symmetric(horizontal: 20, vertical: 10),
              child: Column(
                mainAxisAlignment: MainAxisAlignment.center,
                children: [
                  Text(
                    result != null
                        ? 'QR Code Data: ${result!.code}'
                        : 'Scan a code',
                    style: Theme.of(context).textTheme.headline6,
                  ),
                  SizedBox(height: 20),
                  TextFormField(
                    controller: violationController,
                    decoration: InputDecoration(
                      labelText: 'Violation',
                      border: OutlineInputBorder(),
                    ),
                  ),
                  SizedBox(height: 10),
                  TextFormField(
                    controller: fineAmountController,
                    keyboardType: TextInputType.number,
                    decoration: InputDecoration(
                      labelText: 'Fine Amount',
                      border: OutlineInputBorder(),
                    ),
                  ),
                  SizedBox(height: 10),
                  InkWell(
                    onTap: () {
                      _selectDate(context);
                    },
                    child: Container(
                      padding: EdgeInsets.all(10),
                      decoration: BoxDecoration(
                        border: Border.all(color: Colors.grey),
                        borderRadius: BorderRadius.circular(5),
                      ),
                      child: Text(
                        dueDate.isNotEmpty ? dueDate : 'Select Due Date',
                        style: TextStyle(fontSize: 16),
                      ),
                    ),
                  ),
                  SizedBox(height: 20),
                  ElevatedButton(
                    onPressed: () async {
                      await createSummon();
                    },
                    child: Text('Create Summon',
                        style: TextStyle(color: Colors.white)),
                    style: ElevatedButton.styleFrom(
                      primary: Colors.blueAccent,
                      padding:
                          EdgeInsets.symmetric(horizontal: 50, vertical: 15),
                      textStyle: TextStyle(fontSize: 16),
                    ),
                  ),
                ],
              ),
            ),
          ],
        ),
      ),
    );
  }

  void _onQRViewCreated(QRViewController controller) {
    this.controller = controller;
    controller.scannedDataStream.listen((scanData) {
      setState(() {
        result = scanData;
      });

      controller.pauseCamera();
    });
  }

  Future<void> createSummon() async {
    if (result != null) {
      final prefs = await SharedPreferences.getInstance();
      final securityName = prefs.getString('securityName') ?? '';
      final securityId = prefs.getInt('securityId') ?? '';
      print(dueDate);
      final response = await http.post(
        Uri.parse(
            'https://uniselsummon.duckdns.org/api/guard/createSummon'), // Replace with your API endpoint
        body: {
          'QRCodeId': result!.code,
          'violation': violationController.text,
          'fineAmount': fineAmountController.text,
          'dueDate': dueDate,
          'securityName': securityName,
          'securityId': securityId.toString(),
        },
      );

      print(response.body);
      if (response.statusCode == 200) {
        Fluttertoast.showToast(
          msg: 'Summon created successfully',
          toastLength: Toast.LENGTH_SHORT,
          gravity: ToastGravity.BOTTOM,
          timeInSecForIosWeb: 1,
          backgroundColor: Colors.green,
          textColor: Colors.white,
          fontSize: 16.0,
        );
        resetPage();
      } else {
        Fluttertoast.showToast(
          msg: 'Failed to create summon',
          toastLength: Toast.LENGTH_SHORT,
          gravity: ToastGravity.BOTTOM,
          timeInSecForIosWeb: 1,
          backgroundColor: Colors.red,
          textColor: Colors.white,
          fontSize: 16.0,
        );
      }
    }
  }

  void resetPage() {
    setState(() {
      result = null;
      violationController.clear();
      fineAmountController.clear();
      dueDate = '';
    });

    controller?.resumeCamera();
  }

  String _dueDateErrorMessage = '';

  Future<void> _selectDate(BuildContext context) async {
    final DateTime? pickedDate = await showDatePicker(
      context: context,
      initialDate: DateTime.now(),
      firstDate: DateTime.now(),
      lastDate: DateTime(2100),
    );

    if (pickedDate != null) {
      final formattedDate =
          '${pickedDate.day}/${pickedDate.month}/${pickedDate.year}';
      if (_validateDueDateFormat(formattedDate)) {
        setState(() {
          dueDate = formattedDate;
          _dueDateErrorMessage = ''; // Clear any previous error message
        });
      } else {
        setState(() {
          _dueDateErrorMessage =
              'The due date field must match the format d/m/Y.';
        });
      }
    }
  }

  bool _validateDueDateFormat(String date) {
    // Regular expression to match the format "d/m/Y"
    final RegExp regex = RegExp(r'^\d{1,2}/\d{1,2}/\d{4}$');
    return regex.hasMatch(date);
  }

  @override
  void dispose() {
    controller?.dispose();
    super.dispose();
  }
}
