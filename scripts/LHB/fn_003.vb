Sub FN_003()

    On Error Resume Next ' Enable error handling

    Dim objConn, objRS, sqlQuery, checkQuery
    Dim dbPath, strError, logFile, fso, file, timeStamp
    Dim test_id, draining_125L, draining_75L, draining_150L, bp_strainer, fp_strainer
    Dim all_off, front_fp, rear_fp

    ' SQLite database path
    dbPath = HmiRuntime.SmartTags("DB_PATH")
    logFile = HmiRuntime.SmartTags("LOG_PATH")

    ' Get SmartTag values
    test_id = HmiRuntime.SmartTags("NEW_RTR_TEST_ID")

    ' Convert 1/0 to Yes/No
    If HmiRuntime.SmartTags("125L_OK") = True Then
        draining_125L = "yes"
    Else
        draining_125L = "no"
    End If

    If HmiRuntime.SmartTags("75L_OK") = True Then
        draining_75L = "yes"
    Else
        draining_75L = "no"
    End If

    If HmiRuntime.SmartTags("150L_OK") = True Then
        draining_150L = "yes"
    Else
        draining_150L = "no"
    End If

    If HmiRuntime.SmartTags("BPST_OK") = True Then
        bp_strainer = "yes"
    Else
        bp_strainer = "no"
    End If

    If HmiRuntime.SmartTags("FPST_OK") = True Then
        fp_strainer = "yes"
    Else
        fp_strainer = "no"
    End If

    If HmiRuntime.SmartTags("ALLOFF") = True Then
        all_off = "yes"
    Else
        all_off = "no"
    End If

    front_fp = HmiRuntime.SmartTags("FRONT_FP_VALUE")
    rear_fp = HmiRuntime.SmartTags("REAR_FP_VALUE")

    ' Create ADODB connection object
    Set objConn = CreateObject("ADODB.Connection")
    objConn.Open "Driver={SQLite3 ODBC Driver};Database=" & dbPath & ";"

    ' Check if ID exists
    checkQuery = "SELECT COUNT(*) AS cnt FROM tbl_lhb_01 WHERE id = " & test_id
    Set objRS = objConn.Execute(checkQuery)

    If objRS("cnt") > 0 Then
        ' If exists → UPDATE
        sqlQuery = "UPDATE tbl_lhb_01 SET " & _
                   "draining_of_125l='" & draining_125L & "'," & _
                   "draining_of_75l='" & draining_75L & "'," & _
                   "draining_of_150l='" & draining_150L & "'," & _
                   "bp_strainer='" & bp_strainer & "'," & _
                   "fp_strainer='" & fp_strainer & "'," & _
                   "all_off='" & all_off & "'," & _
                   "front_pwr_car_fp='" & front_fp & "'," & _
                   "rear_pwr_car_fp='" & rear_fp & "' " & _
                   "WHERE id=" & test_id
    Else
        ' If not exists → INSERT
        sqlQuery = "INSERT INTO tbl_lhb_01 (" & _
                   "id, draining_of_125l, draining_of_75l, draining_of_150l, bp_strainer, fp_strainer, all_off, front_pwr_car_fp, rear_pwr_car_fp" & _
                   ") VALUES (" & _
                   test_id & ",'" & draining_125L & "','" & draining_75L & "','" & draining_150L & "','" & bp_strainer & "','" & fp_strainer & "','" & all_off & "','" & front_fp & "','" & rear_fp & "')"
    End If

    ' Execute SQL query
    objConn.Execute sqlQuery

    ' Error handling
    If Err.Number <> 0 Then
        strError = "FN_003 Error: " & Err.Description
        timeStamp = Now

        ' Log error in text file
        Set fso = CreateObject("Scripting.FileSystemObject")
        Set file = fso.OpenTextFile(logFile, 8, True)
        file.WriteLine timeStamp & " - " & strError
        file.Close
        Err.Clear
    End If

    ' Close connection
    objConn.Close
    Set objConn = Nothing
    Set objRS = Nothing

End Sub