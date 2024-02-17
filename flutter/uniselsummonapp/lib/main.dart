import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import 'dart:convert';
import 'package:shared_preferences/shared_preferences.dart';
import 'qrview.dart'; // Ensure this is correctly imported with the correct file name

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
  final _formKey = GlobalKey<FormState>();
  final TextEditingController _usernameController = TextEditingController();
  final TextEditingController _passwordController = TextEditingController();
  String _loginFeedback = '';

  Future<void> _login() async {
    if (!_formKey.currentState!.validate()) {
      // If the form is not valid, return to prevent the login attempt
      return;
    }

    try {
      var response = await http.post(
        Uri.parse('https://uniselsummon.duckdns.org/api/guard/login'),
        headers: <String, String>{
          'Content-Type': 'application/json',
        },
        body: jsonEncode(<String, String>{
          'guard_username': _usernameController.text,
          'password': _passwordController.text,
        }),
      );

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
          MaterialPageRoute(
              builder: (context) =>
                  QRViewExample()), // Ensure this navigates correctly
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
      appBar: AppBar(
        title: Text('Login'), // Changed to just 'Login'
        backgroundColor: Colors.blue, // Customize with Unisel's color
      ),
      body: SingleChildScrollView(
        child: Padding(
          padding: EdgeInsets.all(16),
          child: Form(
            key: _formKey,
            child: Column(
              mainAxisAlignment: MainAxisAlignment.center,
              children: <Widget>[
                Text(
                  'UNISEL Summon System',
                  style: TextStyle(
                    fontSize: 24,
                    fontWeight: FontWeight.bold,
                    color: Colors.blue, // Customize with Unisel's color
                  ),
                ),
                SizedBox(height: 20), // Space after the text logo
                TextFormField(
                  controller: _usernameController,
                  decoration: InputDecoration(
                    labelText: 'Username',
                    border: OutlineInputBorder(),
                    prefixIcon: Icon(Icons.person),
                  ),
                  validator: (value) {
                    if (value == null || value.isEmpty) {
                      return 'Please enter your username';
                    }
                    return null;
                  },
                ),
                SizedBox(height: 16),
                TextFormField(
                  controller: _passwordController,
                  decoration: InputDecoration(
                    labelText: 'Password',
                    border: OutlineInputBorder(),
                    prefixIcon: Icon(Icons.lock),
                  ),
                  obscureText: true,
                  validator: (value) {
                    if (value == null || value.isEmpty) {
                      return 'Please enter your password';
                    }
                    return null;
                  },
                ),
                SizedBox(height: 32),
                ElevatedButton(
                  style: ElevatedButton.styleFrom(
                    primary: Colors.blue, // Customize with Unisel's color
                    shape: RoundedRectangleBorder(
                      borderRadius: BorderRadius.circular(18.0),
                    ),
                    padding: EdgeInsets.symmetric(horizontal: 50, vertical: 15),
                    textStyle: TextStyle(fontSize: 18),
                  ),
                  onPressed: _login,
                  child: Text(
                    'Login',
                    style: TextStyle(color: Colors.white),
                  ),
                ),
                SizedBox(height: 20),
                Text(_loginFeedback),
              ],
            ),
          ),
        ),
      ),
    );
  }
}
