package com.example.calculator;

import java.net.URL;
import java.util.ResourceBundle;
import java.util.regex.Matcher;
import java.util.regex.Pattern;

import javafx.fxml.FXML;
import javafx.scene.control.Button;
import javafx.scene.control.Label;

public class Controller {

    @FXML
    private ResourceBundle resources;

    @FXML
    private URL location;

    @FXML
    private Button but0;

    @FXML
    private Button but1;

    @FXML
    private Button but2;

    @FXML
    private Button but3;

    @FXML
    private Button but4;

    @FXML
    private Button but5;

    @FXML
    private Button but6;

    @FXML
    private Button but7;

    @FXML
    private Button but8;

    @FXML
    private Button but9;

    @FXML
    private Button butDel;

    @FXML
    private Button butEquals;

    @FXML
    private Button butMinus;

    @FXML
    private Button butMult;

    @FXML
    private Button butPixel;

    @FXML
    private Button butPlus;

    @FXML
    private Label labelActive;

    @FXML
    private Label labelStorage;

    @FXML
    private Button butClearActive;

    @FXML
    private Button butClearAll;

    @FXML
    private Button butCloseBracket;

    @FXML
    private Button butOpenBracket;

    private boolean flagAfterCalc = false;

    private byte countOpenBracket = 0;
    private byte countCloseBracket = 0;

    @FXML
    void initialize() {
        but0.setOnAction(event -> {
            printNumber ('0');
        });
        but1.setOnAction(event -> {
            printNumber ('1');
        });
        but2.setOnAction(event -> {
            printNumber ('2');
        });
        but3.setOnAction(event -> {
            printNumber ('3');
        });
        but4.setOnAction(event -> {
            printNumber ('4');
        });
        but5.setOnAction(event -> {
            printNumber ('5');
        });
        but6.setOnAction(event -> {
            printNumber ('6');
        });
        but7.setOnAction(event -> {
            printNumber ('7');
        });
        but8.setOnAction(event -> {
            printNumber ('8');
        });
        but9.setOnAction(event -> {
            printNumber ('9');
        });
        butPlus.setOnAction(event -> {
            printSign('+');
        });
        butMinus.setOnAction(event -> {
            printSign('-');
        });
        butMult.setOnAction(event -> {
            printSign('*');
        });
        butDel.setOnAction(event -> {
            printSign('/');
        });
        butPixel.setOnAction(event ->{
            labelActive.setText(labelActive.getText() + ".");
        });
        butOpenBracket.setOnAction(event -> {
            if (labelActive.getText().isEmpty()){
                labelActive.setText("(");
                countOpenBracket += 1;
            }
        });
        butCloseBracket.setOnAction(event -> {
            if (countOpenBracket > countCloseBracket){
                String labText = labelActive.getText();
                if (!labText.isEmpty()){
                    labelActive.setText(labText + ")");
                    countCloseBracket += 1;
                }
            }
        });
        butClearActive.setOnAction(event -> {
            labelActive.setText("");
        });
        butClearAll.setOnAction(event -> {
            labelActive.setText("");
            labelStorage.setText("");
        });
        butEquals.setOnAction(event -> {
            pushEquals();
        });
    }

    void pushEquals (){
        if (labelActive.getText().length() > 0 && labelStorage.getText().length() > 0 ){
            String inputCalc = labelStorage.getText() + labelActive.getText();

            while (countOpenBracket > countCloseBracket) {
                inputCalc += ")";
                countCloseBracket++;
            }

            String result = calc(inputCalc);
            labelActive.setText(delZeroAfterPixel(result));
            labelStorage.setText("");
            flagAfterCalc = true;
            countOpenBracket = 0;
            countCloseBracket = 0;
        }
    }

    void printNumber (char number) {
        if (flagAfterCalc){
            labelActive.setText("");
            flagAfterCalc = false;
        }
        if (labelActive.getText().equals("0")){
                labelActive.setText(Character.toString(number));
        } else if (labelActive.getText().indexOf(")") != -1) {
            return;
        } else {
            labelActive.setText(labelActive.getText() + number);
        }
    }

    void printSign (char sign) {
        if (labelActive.getText().isEmpty() && labelStorage.getText().isEmpty()){
            return;
        }
        if (labelActive.getText().indexOf(".") != -1){
            labelActive.setText(delZeroAfterPixel(labelActive.getText()));
        }
        if (labelStorage.getText().isEmpty()) {
            labelStorage.setText(labelActive.getText() + sign);
        } else if (labelActive.getText().isEmpty()){
            labelStorage.setText(labelStorage.getText().substring(0, labelStorage.getText().length() - 1) + sign);
        } else if (labelStorage.getText().length() + labelActive.getText().length() + 1 < 27) {
            labelStorage.setText(labelStorage.getText() + labelActive.getText() + sign);
        } else {
            pushEquals();
            labelStorage.setText(labelActive.getText() + sign);
        }
        labelActive.setText("");
    }

    String delZeroAfterPixel (String str){
        if (Double.parseDouble(str) % 1 !=0){
            return str;
        } else {
            return Long.toString((long) Double.parseDouble(str));
        }
    }

    String calc(String str){

        while (str.indexOf("(") != -1 && str.indexOf(")") != -1) {
            int indexOpenBracket = 0;
            int indexCloseBracket = 0;

            for (int i = 0; i < str.length(); i++) {
                if (str.charAt(i) == '('){
                    indexOpenBracket = i;
                } else if (str.charAt(i) == ')'){
                    indexCloseBracket = i;
                    break;
                }
            }
            String strInBracket = str.substring(indexOpenBracket + 1, indexCloseBracket);

            String resCalc = calc(strInBracket);

            str = str.substring(0,indexOpenBracket) + resCalc + str.substring(indexCloseBracket + 1);
        }

        int indexMult = str.indexOf("*");
        int indexDel = str.indexOf("/");
        int indexPlus = str.indexOf("+");
        int indexMinus = str.indexOf("-");

        if (indexMult != -1 || indexDel != -1){

            boolean delVSMult = indexMult != -1 && (indexMult < indexDel || indexDel == -1);

            String str1 = delVSMult ? str.substring(0, indexMult) : str.substring(0, indexDel);
            String str2 = delVSMult ? str.substring(indexMult + 1) : str.substring(indexDel + 1);

            int indexStr1Plus = str1.lastIndexOf("+");
            int indexStr1Minus = str1.lastIndexOf("-");

            int indexStr2Mult = str2.indexOf("*");
            int indexStr2Del = str2.indexOf("/");
            int indexStr2Plus = str2.indexOf("+");
            int indexStr2Minus = str2.indexOf("-");

            if (indexStr2Minus == 0){
                int newIndexMinus = str2.substring(indexStr2Minus + 1).indexOf("-");
                indexStr2Minus = newIndexMinus == -1 ? newIndexMinus : newIndexMinus + 1;
            }
            if (indexStr1Minus != -1){
                if (indexStr1Minus == 0){
                    indexStr1Minus = -1;
                } else if (str1.charAt(indexStr1Minus - 1) == '-') {
                    indexStr1Minus--;
                }
            }

            String firstNumber = "";
            String secondNumber = "";

            boolean checkSignStr1 = indexStr1Minus != -1 || indexStr1Plus != -1;
            boolean checkSignStr2 = indexStr2Mult != -1 || indexStr2Del != -1 || indexStr2Plus != -1 || indexStr2Minus != -1;

            boolean multWin = indexStr2Mult != -1 && (indexStr2Mult < indexStr2Del || indexStr2Del == -1) &&
                    (indexStr2Mult < indexStr2Plus || indexStr2Plus == -1) &&
                    (indexStr2Mult < indexStr2Minus || indexStr2Minus == -1);
            boolean delWin = indexStr2Del != -1 && (indexStr2Del < indexStr2Plus || indexStr2Plus == -1)
                    && (indexStr2Del < indexStr2Minus || indexStr2Minus == -1);
            boolean plusWin = indexStr2Plus != -1 && (indexStr2Plus < indexStr2Minus || indexStr2Minus == -1);

            if (delVSMult){

                if (checkSignStr1){
                    if (indexStr1Plus > indexStr1Minus){
                        firstNumber = str1.substring(indexStr1Plus + 1);
                    } else {
                        firstNumber = str1.substring(indexStr1Minus + 1);
                    }
                } else {
                    firstNumber = str1;
                }

                if (checkSignStr2) {
                    if (multWin) {
                        secondNumber = str2.substring(0, indexStr2Mult);
                    } else if (delWin) {
                        secondNumber = str2.substring(0, indexStr2Del);
                    } else if (plusWin) {
                        secondNumber = str2.substring(0, indexStr2Plus);
                    } else {
                        secondNumber = str2.substring(0, indexStr2Minus);
                    }
                } else {
                    secondNumber = str2;
                }

                double resCalc = Double.parseDouble(firstNumber) * Double.parseDouble(secondNumber);

                if (checkSignStr1 || checkSignStr2){

                    String str3 = "";

                    if (checkSignStr1 && checkSignStr2){

                        if (indexStr1Plus > indexStr1Minus){
                            str3 = str1.substring(0, indexStr1Plus + 1) + resCalc;
                        } else {
                            str3 = str1.substring(0, indexStr1Minus + 1) + resCalc;
                        }

                        if (multWin){
                            str3 += str2.substring(indexStr2Mult);
                        } else if (delWin){
                            str3 += str2.substring(indexStr2Del);
                        } else if (plusWin){
                            str3 += str2.substring(indexStr2Plus);
                        } else {
                            str3 += str2.substring(indexStr2Minus);
                        }

                    } else if (checkSignStr1) {

                        if (indexStr1Plus > indexStr1Minus){
                            str3 = str1.substring(0, indexStr1Plus + 1) + resCalc;
                        } else {
                            str3 = str1.substring(0, indexStr1Minus + 1) + resCalc;
                        }

                    } else {

                        if (multWin){
                            str3 = resCalc + str2.substring(indexStr2Mult);
                        } else if (delWin){
                            str3 = resCalc + str2.substring(indexStr2Del);
                        } else if (plusWin){
                            str3 = resCalc + str2.substring(indexStr2Plus);
                        } else {
                            str3 = resCalc + str2.substring(indexStr2Minus);
                        }
                    }

                    return calc(str3);
                } else {
                    return Double.toString(resCalc);
                }

            } else {
                if (checkSignStr1){
                    if (indexStr1Plus > indexStr1Minus){
                        firstNumber = str1.substring(indexStr1Plus + 1);
                    } else {
                        firstNumber = str1.substring(indexStr1Minus + 1);
                    }
                } else {
                    firstNumber = str1;
                }

                if (checkSignStr2) {
                    if (multWin) {
                        secondNumber = str2.substring(0, indexStr2Mult);
                    } else if (delWin) {
                        secondNumber = str2.substring(0, indexStr2Del);
                    } else if (plusWin) {
                        secondNumber = str2.substring(0, indexStr2Plus);
                    } else {
                        secondNumber = str2.substring(0, indexStr2Minus);
                    }
                } else {
                    secondNumber = str2;
                }

                double resCalc = Double.parseDouble(firstNumber) / Double.parseDouble(secondNumber);

                if (checkSignStr1 || checkSignStr2){

                    String str3 = "";

                    if (checkSignStr1 && checkSignStr2){

                        if (indexStr1Plus > indexStr1Minus){
                            str3 = str1.substring(0, indexStr1Plus + 1) + resCalc;
                        } else {
                            str3 = str1.substring(0, indexStr1Minus + 1) + resCalc;
                        }

                        if (multWin){
                            str3 += str2.substring(indexStr2Mult);
                        } else if (delWin){
                            str3 += str2.substring(indexStr2Del);
                        } else if (plusWin){
                            str3 += str2.substring(indexStr2Plus);
                        } else {
                            str3 += str2.substring(indexStr2Minus);
                        }

                    } else if (checkSignStr1) {

                        if (indexStr1Plus > indexStr1Minus){
                            str3 = str1.substring(0, indexStr1Plus + 1) + resCalc;
                        } else {
                            str3 = str1.substring(0, indexStr1Minus + 1) + resCalc;
                        }

                    } else {

                        if (multWin){
                            str3 = resCalc + str2.substring(indexStr2Mult);
                        } else if (delWin){
                            str3 = resCalc + str2.substring(indexStr2Del);
                        } else if (plusWin){
                            str3 = resCalc + str2.substring(indexStr2Plus);
                        } else {
                            str3 = resCalc + str2.substring(indexStr2Minus);
                        }
                    }

                    return calc(str3);
                } else {
                    return Double.toString(resCalc);
                }
            }
        } else if (indexPlus != -1 || indexMinus != -1){

            boolean plusVsMinus = indexPlus != -1 && (indexPlus < indexMinus || indexMinus == -1);

            if (indexMinus == 0){
                int newIndexMinus = str.substring(indexMinus + 1).indexOf("-");
                if (newIndexMinus == -1 && indexPlus != -1){
                    indexMinus = -1;
                } else if (indexPlus == -1 && newIndexMinus == -1){
                    return str;
                } else {
                    indexMinus = newIndexMinus +1;
                }
            }

            String firstNumber = plusVsMinus ? str.substring(0, indexPlus) : str.substring(0, indexMinus);

            String secondNumber = "";
            String cutStr = plusVsMinus ? str.substring(indexPlus + 1) : str.substring(indexMinus + 1);

            int indexCutStrPlus = cutStr.indexOf("+");
            int indexCutStrMinus = cutStr.indexOf("-");

            if (indexCutStrMinus == 0){
                int newIndexMinus = cutStr.substring(indexCutStrMinus + 1).indexOf("-");
                indexCutStrMinus = newIndexMinus == -1 ? -1 : newIndexMinus + 1;
            }

            boolean flagSign = indexCutStrPlus != -1 || indexCutStrMinus != -1;
            boolean plusWin = indexCutStrPlus != -1 && (indexCutStrPlus < indexCutStrMinus || indexCutStrMinus == -1);

            if (plusVsMinus) {
                if (flagSign){
                    if (plusWin){
                        secondNumber = cutStr.substring(0, indexCutStrPlus);
                    } else {
                        secondNumber = cutStr.substring(0, indexCutStrMinus);
                    }
                } else {
                    secondNumber = cutStr;
                }

                double resCalc = Double.parseDouble(firstNumber) + Double.parseDouble(secondNumber);

                String finalStr = "";

                if(flagSign) {
                    if (plusWin){
                        finalStr = resCalc + cutStr.substring(indexCutStrPlus);
                    } else {
                        finalStr = resCalc + cutStr.substring(indexCutStrMinus);
                    }
                    return calc(finalStr);
                } else {
                    return Double.toString(resCalc);
                }
            } else {
                if (flagSign){
                    if (plusWin){
                        secondNumber = cutStr.substring(0, indexCutStrPlus);
                    } else {
                        secondNumber = cutStr.substring(0, indexCutStrMinus);
                    }
                } else {
                    secondNumber = cutStr;
                }

                double resCalc = Double.parseDouble(firstNumber) - Double.parseDouble(secondNumber);

                String finalStr = "";

                if(flagSign) {
                    if (plusWin){
                        finalStr = resCalc + cutStr.substring(indexCutStrPlus);
                    } else {
                        finalStr = resCalc + cutStr.substring(indexCutStrMinus);
                    }
                    return calc(finalStr);
                } else {
                    return Double.toString(resCalc);
                }
            }
        }
        return str;
    }
}
