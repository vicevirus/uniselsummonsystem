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
      body: Column(
        children: <Widget>[
          Expanded(
            flex: 5,
            child: QRView(
              key: qrKey,
              onQRViewCreated: _onQRViewCreated,
            ),
          ),
          Column(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              (result != null)
                  ? Text('QR Code Data: ${result!.code}')
                  : Text('Scan a code'),
              TextField(
                controller: violationController,
                decoration: InputDecoration(labelText: 'Violation'),
              ),
              TextField(
                controller: fineAmountController,
                keyboardType: TextInputType.number,
                decoration: InputDecoration(labelText: 'Fine Amount'),
              ),
              InkWell(
                onTap: () {
                  _selectDate(context);
                },
                child: Container(
                  margin: EdgeInsets.symmetric(vertical: 10),
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
              ElevatedButton(
                onPressed: () async {
                  await createSummon();
                },
                child: Text('Create Summon'),
              ),
            ],
          ),
        ],
      ),
    );
  }

  void _onQRViewCreated(QRViewController controller) {
    this.controller = controller;
    controller.scannedDataStream.listen((scanData) {
      setState(() {
        result = scanData;
      });

      // Pause camera after detecting a result
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
            'http://10.0.2.2:8000/api/guard/createSummon'), // Replace with your API endpoint
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
