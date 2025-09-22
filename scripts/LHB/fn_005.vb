Sub FN_005()

    On Error Resume Next ' Enable error handling

    Dim objConn, objRS, sqlQuery, checkQuery
    Dim dbPath, logFile, strError, fso, file, timeStamp
    Dim test_id, bp_value, fp_value, attended_leakage, ar_tank_empty, cr_tank_empty, defect_persist

    ' Database and log paths from SmartTags
    dbPath = HmiRuntime.SmartTags("DB_PATH")
    logFile = HmiRuntime.SmartTags("LOG_PATH")

    ' Fetch ID
    test_id = HmiRuntime.SmartTags("NEW_RTR_TEST_ID")

    ' Get SmartTag values for numeric fields
    bp_value = Round(CDbl(HmiRuntime.SmartTags("ISG_START_READ_VALUE_AI_1")), 2)
    fp_value = Round(CDbl(HmiRuntime.SmartTags("ISG_START_READ_VALUE_AI_2")), 2)

    ' Get SmartTag values for numeric fields
    ' bp_value =  Round(CDbl(HmiRuntime.SmartTags("ISG_ACTUAL_VALUE_AI_1")), 2)
    ' fp_value =  Round(CDbl(HmiRuntime.SmartTags("ISG_ACTUAL_VALUE_AI_2")), 2)

    ' Convert 1 → Yes / No
    If HmiRuntime.SmartTags("SEALING_ATTENDED_LEAKAGE_BIT") = True Then
        attended_leakage = "Yes"
    Else
        attended_leakage = "No"
    End If

    If HmiRuntime.SmartTags("SEALING_AR_TANK_EMPTY_BIT") = True Then
        ar_tank_empty = "Yes"
    Else
        ar_tank_empty = "No"
    End If

    If HmiRuntime.SmartTags("SEALING_CR_TANK_EMPTY_BIT") = True Then
        cr_tank_empty = "Yes"
    Else
        cr_tank_empty = "No"
    End If

    ' Convert defect persist: 1 → Sick / else → Not Sick
    If HmiRuntime.SmartTags("SEALING_DEFECT_PERSIST_BIT") = True Then
        defect_persist = "Sick"
    Else
        defect_persist = "Not Sick"
    End If

    ' Create ADODB connection
    Set objConn = CreateObject("ADODB.Connection")
    objConn.Open "Driver={SQLite3 ODBC Driver};Database=" & dbPath & ";"

    If Err.Number <> 0 Then
        strError = "Error in FN_005 : Failed to connect to database - " & Err.Description
        timeStamp = Now
        Set fso = CreateObject("Scripting.FileSystemObject")
        Set file = fso.OpenTextFile(logFile, 8, True)
        file.WriteLine timeStamp & " - " & strError
        file.Close
        Err.Clear
        Exit Sub
    End If

    ' Check if ID exists
    checkQuery = "SELECT COUNT(*) AS cnt FROM tbl_lhb_03 WHERE id = " & test_id
    Set objRS = objConn.Execute(checkQuery)

    If objRS("cnt") > 0 Then
        ' If exists → UPDATE
        sqlQuery = "UPDATE tbl_lhb_03 SET " & _
                   "bp_value=" & bp_value & "," & _
                   "fp_value=" & fp_value & "," & _
                   "attended_any_leakage='" & attended_leakage & "'," & _
                   "ar_tank_empty='" & ar_tank_empty & "'," & _
                   "cr_tank_empty='" & cr_tank_empty & "'," & _
                   "defect_persist='" & defect_persist & "' " & _
                   "WHERE id=" & test_id
    Else
        ' If not exists → INSERT
        sqlQuery = "INSERT INTO tbl_lhb_03 (" & _
                   "id, bp_value, fp_value, attended_any_leakage, ar_tank_empty, cr_tank_empty, defect_persist" & _
                   ") VALUES (" & _
                   test_id & "," & bp_value & "," & fp_value & ",'" & attended_leakage & "','" & ar_tank_empty & "','" & cr_tank_empty & "','" & defect_persist & "')"
    End If

    ' Execute SQL query
    objConn.Execute sqlQuery

    ' Error handling
    If Err.Number <> 0 Then
        strError = "Error in FN_005 : SQL execution failed - " & Err.Description & " | Query: " & sqlQuery
        timeStamp = Now
        Set fso = CreateObject("Scripting.FileSystemObject")
        Set file = fso.OpenTextFile(logFile, 8, True)
        file.WriteLine timeStamp & " - " & strError
        file.Close
        Err.Clear
        objConn.Close
        Set objConn = Nothing
        Set objRS = Nothing
        Exit Sub
    End If

    ' Close connection
    objConn.Close
    Set objConn = Nothing
    Set objRS = Nothing

End Sub