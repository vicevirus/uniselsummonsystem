import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import 'dart:convert';
import 'package:shared_preferences/shared_preferences.dart';
import 'qrview.dart'; // Replace 'qr_view_example.dart' with the correct file name

void main() {
  runApp(MyApp());
}

class MyApp extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      home: LoginPage(),
    );
  }
}

class LoginPage extends StatefulWidget {
  @override
  _LoginPageState createState() => _LoginPageState();
}

class _LoginPageState extends State<LoginPage> {
  final TextEditingController _usernameController = TextEditingController();
  final TextEditingController _passwordController = TextEditingController();
  String _loginFeedback = '';

  Future<void> _login() async {
    try {
      var response = await http.post(
        Uri.parse('http://10.0.2.2:8000/api/guard/login'),
        headers: <String, String>{
          'Content-Type': 'application/json',
        },
        body: jsonEncode(<String, String>{
          'guard_username': _usernameController.text,
          'password': _passwordController.text,
        }),
      );

      print(1);

      if (response.statusCode == 200) {
        var token = jsonDecode(response.body)['token'];
        var securityId = jsonDecode(response.body)['securityId'];
        var securityName = jsonDecode(response.body)['securityName'];
        final prefs = await SharedPreferences.getInstance();
        await prefs.setString('api_token', token);
        await prefs.setInt('securityId', securityId);
        await prefs.setString('securityName', securityName);

        setState(() {
          _loginFeedback = 'Authenticated!';
        });
        Navigator.push(
          context,
          MaterialPageRoute(builder: (context) => QRViewExample()),
        );
      } else {
        setState(() {
          _loginFeedback = 'Wrong credentials!';
        });
      }
    } catch (e) {
      setState(() {
        _loginFeedback = 'Error connecting to the API';
      });
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: Text('Login')),
      body: Padding(
        padding: EdgeInsets.all(16),
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: <Widget>[
            TextField(
              controller: _usernameController,
              decoration: InputDecoration(labelText: 'Username'),
            ),
            SizedBox(height: 8),
            TextField(
              controller: _passwordController,
              decoration: InputDecoration(labelText: 'Password'),
              obscureText: true,
            ),
            SizedBox(height: 20),
            ElevatedButton(
              onPressed: _login,
              child: Text('Login'),
            ),
            SizedBox(height: 20),
            Text(_loginFeedback),
          ],
        ),
      ),
    );
  }
}
