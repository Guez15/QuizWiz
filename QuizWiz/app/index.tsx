import {View,Text, Pressable} from "react-native";
import React from 'react';
import { router } from "expo-router";

const HomePage = ()=>{
    return (<View>
        <Text>Home page</Text>
        <Pressable onPress={() => router.push("login")}>
            <Text>Pagina Login</Text>
        </Pressable>
    </View>);
}

export default HomePage;
