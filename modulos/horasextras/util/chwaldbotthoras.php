<?php
//variables locales para almacenar los valores de las propiedades
Private mvarDocumento As Double //copia local
Private mvarLegajo As String //copia local
Private mvarEstado As Integer //copia local
Private mvarHsSimples As Double //copia local
Private mvarHsExtras As Double //copia local
Private mvarHsJornales As Double //copia local
Private mvarEscPreEscolar As Integer //copia local
Private mvarEscPrimaria As Integer //copia local
Private mvarEscSecundaria As Integer //copia local
Private mvarEscDiscap As Integer //copia local

Public Property Let EscDiscap(ByVal vData As Integer)
    mvarEscDiscap = vData
End Property
Public Property Get EscDiscap() As Integer
    EscDiscap = mvarEscDiscap
End Property
Public Property Let EscSecundaria(ByVal vData As Integer)
    mvarEscSecundaria = vData
End Property
Public Property Get EscSecundaria() As Integer
    EscSecundaria = mvarEscSecundaria
End Property
Public Property Let EscPrimaria(ByVal vData As Integer)
    mvarEscPrimaria = vData
End Property
Public Property Get EscPrimaria() As Integer
    EscPrimaria = mvarEscPrimaria
End Property
Public Property Let EscPreEscolar(ByVal vData As Integer)
    mvarEscPreEscolar = vData
End Property
Public Property Get EscPreEscolar() As Integer
    EscPreEscolar = mvarEscPreEscolar
End Property
Public Property Let HsJornales(ByVal vData As Double)
    mvarHsJornales = vData
End Property
Public Property Get HsJornales() As Double
    HsJornales = mvarHsJornales
End Property
Public Property Let HsExtras(ByVal vData As Double)
    mvarHsExtras = vData
End Property
Public Property Get HsExtras() As Double
    HsExtras = mvarHsExtras
End Property
Public Property Let HsSimples(ByVal vData As Double)
   mvarHsSimples = vData
End Property
Public Property Get HsSimples() As Double
    HsSimples = mvarHsSimples
End Property
Public Property Let Estado(ByVal vData As Integer)
    mvarEstado = vData
End Property
Public Property Get Estado() As Integer
    Estado = mvarEstado
End Property
Public Property Let Legajo(ByVal vData As String)
    mvarLegajo = vData
End Property
Public Property Get Legajo() As String
    Legajo = mvarLegajo
End Property
Public Property Let Documento(ByVal vData As Double)
    mvarDocumento = vData
End Property
Public Property Get Documento() As Double
    Documento = mvarDocumento
End Property
Private Function Conectar(ByVal I_sTexto As String, ByVal I_eTipoCD As CommandTypeEnum) As ADODB.Recordset
On Error GoTo HayError:

   Dim oCN As ADODB.Connection
   Dim oCD As ADODB.Command
   Dim oRs As ADODB.Recordset

   Set oCN = CreateObject("ADODB.Connection")

   Set oCD = CreateObject("ADODB.Command")
   Set oRs = CreateObject("ADODB.Recordset")
   With oCN
      .ConnectionString = "FILE NAME=" & App.Path & "\Sueldos.udl"
      .Open
   End With
   With oRs
      .CursorLocation = adUseClient
      .LockType = adLockBatchOptimistic
   End With
   With oCD
      .CommandText = I_sTexto
      .CommandType = I_eTipoCD
      Set .ActiveConnection = oCN
      If I_Codigo <> "" Then
        .Parameters.Refresh
        .Parameters("@prmCodigo").Value = I_Codigo
        End If
   End With
   With oRs
      .Open oCD
      'Set .ActiveConnection = Nothing
   End With
   Set Conectar = oRs
'   Set oRs = Nothing
   Set oCD = Nothing
   Set oCN = Nothing
    Exit Function

HayError:
   Set Conectar = oRs
   Set oRs = Nothing
   Set oCD = Nothing
   Set oCN = Nothing
   ''''''''''''''''''''
End Function
Public Function BuscaLegajo() As Boolean
Dim Rs As ADODB.Recordset
xSql = "Select * From Empleado where NroDocto=" & mvarDocumento & ";"
Set Rs = Conectar(xSql, adCmdText)
If Rs.EOF And Rs.BOF Then
    BuscaLegajo = False
    Else
    BuscaLegajo = True
    mvarEstado = Rs.Fields("Condicion")
    mvarLegajo = Rs.Fields("Empleado")
    End If
Rs.Close
Set Rs = Nothing
End Function
Public Function ExportarHs() As Boolean
Dim xRs As ADODB.Recordset
Dim xSql As String
xSql = "select * From Horas where Empleado='" & mvarLegajo & "';"
Set xRs = Conectar(xSql, adCmdText)
If xRs.EOF And xRs.BOF Then
    ExportarHs = False
    Else
    ExportarHs = True
    xRs.Fields("Horas1") = mvarHsJornales
    xRs.Fields("Horas40") = mvarHsSimples
    xRs.Fields("Horas41") = mvarHsExtras
    xRs.UpdateBatch
    End If
xRs.Close
Set xRs = Nothing
End Function
Public Function ExportarPresentismo() As Boolean
Dim xSql As String
Dim xRs As ADODB.Recordset
Dim xAdic As String
Dim xAuNew As String
xSql = "select * From Empleado where Empleado.empleado='" & mvarLegajo & "';"
Set xRs = Conectar(xSql, adCmdText)
If xRs.EOF And xRs.BOF Then
    ExportarPresentismo = False
    xRs.Close
    Else
    xAdic = xRs.Fields("Adicional")
    xAuNew = Left(xAdic, 1)
    xAuNew = xAuNew & "N" & Mid(xAdic, 3, 20)
    xRs.Fields("Adicional") = xAuNew
    xRs.UpdateBatch
    ExportarPresentismo = True
    End If
xRs.Close
Set xRs = Nothing

'        xAuNew = Left(xAu, 1)
'        'Pagar a Todos
'        xAuNew = xAuNew & " " & Mid(xAu, 3, 20)
'        'No pagar a nadie
'        'xAuNew = xAuNew & "N" & Mid(xAu, 3, 20)
'    DoEvents
End Function
Public Function ExportarEscolaridad() As Boolean
Dim xRs As ADODB.Recordset
Dim xSql As String
xSql = "select * From Empleado where Empleado='" & mvarLegajo & "';"
Set xRs = Conectar(xSql, adCmdText)
If xRs.EOF And xRs.BOF Then
    ExportarEscolaridad = False
    Else
    ExportarEscolaridad = True
    xRs.Fields("AsigFliar6") = mvarEscPreEscolar
    xRs.Fields("AsigFliar9") = mvarEscPrimaria
    xRs.Fields("AsigFliar14") = mvarEscSecundaria
    xRs.Fields("AsigFliar8") = mvarEscDiscap
    xRs.UpdateBatch
    End If
xRs.Close
Set xRs = Nothing
End Function

?>
